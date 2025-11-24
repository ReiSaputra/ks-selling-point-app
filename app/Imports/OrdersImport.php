<?php

namespace App\Imports;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\DB;

class OrdersImport implements ToCollection, WithHeadingRow, WithChunkReading, WithBatchInserts, ShouldQueue
{
    public function collection(Collection $rows)
    {
        $grouped = [];

        foreach ($rows as $row) {
            $invoice = $row['invoice_number'];

            if (!isset($grouped[$invoice])) {
                $couponArray = array_filter(explode('|', $row['coupon'] ?? ''));

                $grouped[$invoice] = [
                    'order' => [
                        'invoice_number' => $row['invoice_number'],
                        'marketplace_invoice' => $row['marketplace_invoice_number'],
                        'channel' => $row['channel'],
                        'subtotal' => $row['subtotal'],
                        'discount' => $row['discount'],
                        'shipping_cost' => $row['shipping_cost'],
                        'order_status' => $row['order_status'],
                        'expedition' => $row['expedition'],
                        'shipping_receipt' => $row['shipping_receipt'],
                        'note' => $row['note'],
                        'coupon' => $couponArray ? json_encode($couponArray) : null,
                        'admin_fee' => $row['admin_fee'],
                        'vat' => $row['vat'],
                        'total' => $row['total'],
                        'payment_type' => $row['payment_type'],
                        'created_at' => now(),
                        'updated_at' => now(),
                    ],
                    'details' => []
                ];
            }

            $grouped[$invoice]['details'][] = [
                'product_sku' => $row['product_sku'],
                'price' => $row['price'],
                'actual_price' => $row['actual_price'],
                'product_cost' => $row['product_cost'],
                'quantity' => $row['quantity'],
                'subtotal' => $row['product_subtotal'],
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::transaction(function () use ($grouped) {
            $invoices = array_keys($grouped);

            $existing = DB::table('orders')
                ->whereIn('invoice_number', $invoices)
                ->pluck('id', 'invoice_number')
                ->toArray();

            $ordersToInsert = [];

            foreach ($grouped as $invoice => $data) {
                if (!isset($existing[$invoice])) {
                    $ordersToInsert[] = $data['order'];
                }
            }

            if (!empty($ordersToInsert)) {
                DB::table('orders')->insert($ordersToInsert);

                $new = DB::table('orders')
                    ->whereIn('invoice_number', array_column($ordersToInsert, 'invoice_number'))
                    ->pluck('id', 'invoice_number')
                    ->toArray();

                $existing = array_merge($existing, $new);
            }

            $detailsToInsert = [];

            foreach ($grouped as $invoice => $data) {
                $orderId = $existing[$invoice];

                foreach ($data['details'] as $detail) {
                    $detail['order_id'] = $orderId;
                    $detailsToInsert[] = $detail;
                }
            }

            foreach (array_chunk($detailsToInsert, 1000) as $chunk) {
                DB::table('order_details')->insert($chunk);
            }
        });
    }

    public function chunkSize(): int
    {
        return 1000;
    }

    public function batchSize(): int
    {
        return 500;
    }
}
