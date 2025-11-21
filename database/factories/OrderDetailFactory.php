<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class OrderDetailFactory extends Factory
{
    protected $model = OrderDetail::class;

    public function definition()
    {
        $price        = $this->faker->randomFloat(2, 10000, 100000);
        $quantity     = $this->faker->numberBetween(1, 5);
        $actual_price = $price - $this->faker->randomFloat(2, 0, 5000); // harga setelah diskon
        $subtotal     = $actual_price * $quantity;

        return [
            'order_id'     => Order::factory(), // kalau ingin otomatis
            'product_sku'  => strtoupper(Str::random(8)),
            'price'        => $price,
            'actual_price' => $actual_price,
            'product_cost' => $this->faker->randomFloat(2, 5000, 80000),
            'quantity'     => $quantity,
            'subtotal'     => $subtotal,
        ];
    }
}
