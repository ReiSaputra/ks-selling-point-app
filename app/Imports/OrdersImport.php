<?php

namespace App\Imports;

use App\Order;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class OrdersImport implements ToCollection, WithHeadingRow, WithChunkReading
{
    public function collection(Collection $rows)
    {
        $data = [];

        foreach ($rows as $row) {
            $data[] = [
                'invoice_number' => $row['invoice_number'],
                'marketplace_invoice' => $row['marketplace_invoice'],
                'channel' => $row['channel'],
                'subtotal' => $row['subtotal'],
                'discount' => $row['discount'],
                'shipping_cost' => $row['shipping_cost'],
                'order_status' => $row['order_status'],
                'expedition' => $row['expedition'],
                'shipping_receipt' => $row['shipping_receipt'],
                'note' => $row['note'],
                'coupon' => json_encode($row['coupon']),
                'admin_fee' => $row['admin_fee'],
                'vat' => $row['vat'],
                'total' => $row['total'],
                'payment_type' => $row['payment_type'],
            ];
        }

        Order::insert($data);
    }

    public function chunkSize(): int
    {
        return 500;
    }
}
