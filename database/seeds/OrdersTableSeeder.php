<?php

use Illuminate\Database\Seeder;
use App\Order;

class OrdersTableSeeder extends Seeder
{


    public function run()
    {
        factory(App\Order::class, 10000)->create()->each(function ($order) {
            $order->details()->saveMany(
                factory(App\OrderDetail::class, rand(1, 5))->make()
            );
        });
    }
}
