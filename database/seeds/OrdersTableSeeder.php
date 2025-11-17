<?php

use Illuminate\Database\Seeder;
use App\Order;

class OrdersTableSeeder extends Seeder
{
    public function run()
    {
        // Buat 2 order untuk user dengan id 1
        Order::create([
            'invoice_number' => 'INV-1001',
            'marketplace_invoice' => 'MP-1001',
            'channel' => 'Shopee',
            'subtotal' => 300000,
            'discount' => 50000,
            'shipping_cost' => 20000,
            'order_status' => 'completed',
            'expedition' => 'JNE',
            'shipping_receipt' => 'JNE123456789',
            'note' => 'Packing rapi ya',
            'coupon' => json_encode(['code' => 'DISKON50', 'amount' => 50000]),
            'admin_fee' => 3000,
            'vat' => 10000,
            'total' => 283000,
            'payment_type' => 'e-wallet',
            'user_id' => 1
        ]);

        Order::create([
            'invoice_number' => 'INV-1002',
            'marketplace_invoice' => 'MP-1002',
            'channel' => 'Tokopedia',
            'subtotal' => 150000,
            'discount' => 0,
            'shipping_cost' => 10000,
            'order_status' => 'processing',
            'expedition' => 'SiCepat',
            'shipping_receipt' => 'SCP987654321',
            'note' => null,
            'coupon' => null,
            'admin_fee' => 2500,
            'vat' => 5000,
            'total' => 167500,
            'payment_type' => 'bank_transfer',
            'user_id' => 1
        ]);
    }
}
