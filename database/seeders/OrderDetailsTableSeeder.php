<?php

use Illuminate\Database\Seeder;
use App\Models\OrderDetail;

class OrderDetailsTableSeeder extends Seeder
{
    public function run()
    {
        // Order ID 1
        OrderDetail::create([
            'order_id' => 1,
            'product_sku' => 'SKU-001',
            'price' => 150000,
            'actual_price' => 145000,
            'product_cost' => 100000,
            'quantity' => 2,
            'subtotal' => 300000
        ]);

        // Order ID 2
        OrderDetail::create([
            'order_id' => 2,
            'product_sku' => 'SKU-002',
            'price' => 150000,
            'actual_price' => 150000,
            'product_cost' => 110000,
            'quantity' => 1,
            'subtotal' => 150000
        ]);
    }
}
