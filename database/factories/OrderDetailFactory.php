<?php

namespace Database\Factories;

use App\Models\OrderDetail;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class OrderDetailFactory extends Factory
{
    protected $model = OrderDetail::class;

    public function definition()
    {
        return [
            'product_sku'  => strtoupper(Str::random(8)),
            'price'        => $this->faker->randomFloat(2, 10000, 100000),
            'actual_price' => $this->faker->randomFloat(2, 10000, 100000),
            'product_cost' => $this->faker->randomFloat(2, 5000, 80000),
            'quantity'     => $this->faker->numberBetween(1, 5),
            'subtotal'     => $this->faker->randomFloat(2, 20000, 300000),
        ];
    }
}
