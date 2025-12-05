<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

class ImportOrdersChunk implements ShouldQueue
{

    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $chunkRows; // array of raw CSV rows (associative)

    public $tries = 3;
    public $timeout = 300;

    /**
     * Create a new job instance.
     */
    public function __construct(array $chunkRows)
    {
        //
        $this->chunkRows = $chunkRows;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        if (empty($this->chunkRows)) {
            return;
        }

        // Map invoice_number => order payload (first occurrence)
        $orderMap = [];
        $orderInvoiceNumbers = [];

        $detailInserts = [];

        foreach ($this->chunkRows as $row) {
            $invoice = trim($row['invoice_number']);

            // prepare order payload once per invoice
            if (!isset($orderMap[$invoice])) {
                $coupon = null;
                if (!empty($row['coupon'])) {
                    $decoded = json_decode($row['coupon'], true);
                    $coupon = $decoded ?? $row['coupon'];
                }

                $orderMap[$invoice] = [
                    'invoice_number' => $invoice,
                    'marketplace_invoice' => $row['marketplace_invoice_number'] ?? $row['marketplace_invoice'] ?? null,
                    'channel' => $row['channel'] ?? null,
                    'subtotal' => $this->floatOrZero($row['subtotal'] ?? 0),
                    'discount' => $this->floatOrZero($row['discount'] ?? 0),
                    'shipping_cost' => $this->floatOrZero($row['shipping_cost'] ?? 0),
                    'order_status' => $row['order_status'] ?? null,
                    'expedition' => $row['expedition'] ?? null,
                    'shipping_receipt' => $row['shipping_receipt'] ?? null,
                    'note' => $row['note'] ?? null,
                    'coupon' => $coupon,
                    'admin_fee' => $this->floatOrZero($row['admin_fee'] ?? 0),
                    'vat' => $this->floatOrZero($row['vat'] ?? 0),
                    'total' => $this->floatOrZero($row['total'] ?? 0),
                    'payment_type' => $row['payment_type'] ?? null,
                    'updated_at' => now(),
                    'created_at' => now(),
                ];

                $orderInvoiceNumbers[] = $invoice;
            }

            foreach($orderInvoiceNumbers as $invoice) {
                print($invoice);
            }

            // prepare order_detail row
            $detailInserts[] = [
                // order_id -> fill later after upsert & fetching ids
                'order_invoice_number' => $invoice,
                'product_sku' => $row['product_sku'] ?? null,
                'price' => $this->floatOrZero($row['price'] ?? 0),
                'actual_price' => $this->floatOrNull($row['actual_price'] ?? null),
                'product_cost' => $this->floatOrZero($row['product_cost'] ?? 0),
                'quantity' => (int) ($row['quantity'] ?? 0),
                'subtotal' => $this->floatOrZero($row['product_subtotal'] ?? $row['subtotal'] ?? 0),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        // Do DB operations in transaction (upsert orders, then insert details)
        DB::beginTransaction();

        try {
            // Upsert orders by invoice_number (insert new or update timestamps)
            $ordersToUpsert = array_values($orderMap);

            // Upsert: unique by invoice_number, update these columns if exists
            DB::table('orders')->upsert(
                $ordersToUpsert,
                ['invoice_number'], // unique key
                ['updated_at', 'subtotal', 'discount', 'shipping_cost', 'order_status', 'expedition', 'shipping_receipt', 'note', 'coupon', 'admin_fee', 'vat', 'total', 'payment_type', 'marketplace_invoice'] // columns to update on conflict
            );

            // Fetch ids for these invoice_numbers
            $orderRecords = DB::table('orders')
                ->whereIn('invoice_number', $orderInvoiceNumbers)
                ->select('id', 'invoice_number')
                ->get()
                ->keyBy('invoice_number')
                ->toArray();

            // Build final order_details with order_id
            $finalDetails = [];
            foreach ($detailInserts as $d) {
                $invoice = $d['order_invoice_number'];
                if (!isset($orderRecords[$invoice])) {
                    // Skip if order not found (shouldn't happen)
                    continue;
                }
                $finalDetails[] = [
                    'order_id' => $orderRecords[$invoice]->id,
                    'product_sku' => $d['product_sku'],
                    'price' => $d['price'],
                    'actual_price' => $d['actual_price'],
                    'product_cost' => $d['product_cost'],
                    'quantity' => $d['quantity'],
                    'subtotal' => $d['subtotal'],
                    'created_at' => $d['created_at'],
                    'updated_at' => $d['updated_at'],
                ];
            }

            // Batch insert details in chunks if very large
            $insertChunkSize = 500;
            foreach (array_chunk($finalDetails, $insertChunkSize) as $sub) {
                DB::table('order_details')->insert($sub);
            }

            DB::commit();
        } catch (Throwable $e) {
            DB::rollBack();
            // optional: rethrow to let queue retry, or log
            throw $e;
        }
    }

    private function floatOrZero($val)
    {
        if ($val === null || $val === '')
            return 0.0;
        return (float) str_replace(',', '', $val);
    }

    private function floatOrNull($val)
    {
        if ($val === null || $val === '')
            return null;
        return (float) str_replace(',', '', $val);
    }
}
