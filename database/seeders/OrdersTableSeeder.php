<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Order;
use App\Models\OrderDetail;

class OrdersTableSeeder extends Seeder
{
    public function run()
    {
        Order::factory()
            ->count(100)
            ->create()
            ->each(function ($order) {
                $order->details()->save(
                    OrderDetail::factory()->make()
                );
            });
    }
}
