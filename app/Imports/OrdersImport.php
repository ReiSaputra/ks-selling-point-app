<?php

namespace App\Imports;

use App\Models\Order;
use App\Models\OrderDetail;
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
                $coupons = $row['coupon'] ?? '';
                $couponArray = array_filter(explode('|', $coupons));

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
                        'coupon' => !empty($couponArray) ? json_encode($couponArray, JSON_UNESCAPED_UNICODE) : null,
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

        $existingInvoices = Order::whereIn('invoice_number', array_keys($grouped))
            ->pluck('id', 'invoice_number')
            ->toArray();

        $ordersToInsert = [];
        $detailsToInsert = [];

        foreach ($grouped as $invoice => $data) {
            if (!isset($existingInvoices[$invoice])) {
                $ordersToInsert[$invoice] = $data['order'];
            }
        }

        if ($ordersToInsert) {
            DB::table('orders')->insert($ordersToInsert);

            $newOrders = Order::whereIn('invoice_number', array_keys($ordersToInsert))
                ->pluck('id', 'invoice_number')
                ->toArray();

            $existingInvoices = array_merge($existingInvoices, $newOrders);
        }

        foreach ($grouped as $invoice => $data) {
            $orderId = $existingInvoices[$invoice];

            foreach ($data['details'] as $detail) {
                $detail['order_id'] = $orderId;
                $detailsToInsert[] = $detail;
            }
        }

        $chunks = array_chunk($detailsToInsert, 1000);
        foreach ($chunks as $chunk) {
            DB::table('order_details')->insert($chunk);
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
