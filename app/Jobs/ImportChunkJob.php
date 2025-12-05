<?php

namespace App\Jobs;

use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ImportChunkJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $header;
    protected $rows;

    public function __construct($header, $rows)
    {
        $this->header = $header;
        $this->rows = $rows;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        foreach ($this->rows as $row) {

            // mapping angka → nama kolom
            $row = array_combine($this->header, $row);

            // ubah ke lowercase semua key
            $row = array_change_key_case($row, CASE_LOWER);

            // 1. Convert coupon string → array
            $coupon = null;
            if (!empty($row['coupon'])) {
                $coupon = explode('|', $row['coupon']);
            }

            // 2. Find or create Order
            $order = Order::firstOrCreate(
                [
                    'invoice_number' => $row['invoice_number'],
                ],
                [
                    'marketplace_invoice' => $row['marketplace_invoice_number'] ?? null,
                    'channel' => $row['channel'] ?? null,
                    'subtotal' => $row['subtotal'] ?? 0,
                    'discount' => $row['discount'] ?? 0,
                    'shipping_cost' => $row['shipping_cost'] ?? 0,
                    'order_status' => $row['order_status'] ?? null,
                    'expedition' => $row['expedition'] ?? null,
                    'shipping_receipt' => $row['shipping_receipt'] ?? null,
                    'note' => $row['note'] ?? null,
                    'coupon' => $coupon,
                    'admin_fee' => $row['admin_fee'] ?? 0,
                    'vat' => $row['vat'] ?? 0,
                    'total' => $row['total'] ?? 0,
                    'payment_type' => $row['payment_type'] ?? null,
                ]
            );

            // 3. Insert Order Detail
            OrderDetail::create([
                'order_id' => $order->id,
                'product_sku' => $row['product_sku'],
                'price' => $row['price'],
                'actual_price' => $row['actual_price'],
                'product_cost' => $row['product_cost'],
                'quantity' => $row['quantity'],
                'subtotal' => $row['product_subtotal'],
            ]);
        }
    }
}
