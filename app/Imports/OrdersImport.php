<?php

namespace App\Imports;

use App\Order;
use App\OrderDetail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class OrdersImport implements ToCollection, WithHeadingRow, WithChunkReading, WithBatchInserts, ShouldQueue
{
    public function collection(Collection $rows)
    {
        $grouped = [];

        foreach ($rows as $row) {
            $invoice = $row['invoice_number'];

            if (!isset($grouped[$invoice])) {
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
                        'coupon' => explode('|', $row['coupon']),
                        'admin_fee' => $row['admin_fee'],
                        'vat' => $row['vat'],
                        'total' => $row['total'],
                        'payment_type' => $row['payment_type'],
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
            ];
        }

        foreach ($grouped as $invoice => $data) {

            $existing = Order::where('invoice_number', $invoice)->first();

            if ($existing) {
                $order = $existing;
            } else {
                $order = Order::create($data['order']);
            }

            foreach ($data['details'] as $detail) {
                $detail['order_id'] = $order->id;
                OrderDetail::create($detail);
            }
        }
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
