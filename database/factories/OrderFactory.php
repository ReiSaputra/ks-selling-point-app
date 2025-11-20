<?php

namespace Database\Factories;

use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class OrderFactory extends Factory
{
    protected $model = Order::class;

    public function definition()
    {
        return [
            'invoice_number'     => strtoupper(Str::random(10)),
            'marketplace_invoice'=> strtoupper(Str::random(10)),
            'channel'            => $this->faker->randomElement(['Shopee','Tokopedia','Lazada']),
            'subtotal'           => $this->faker->randomFloat(2, 10000, 1000000),
            'discount'           => $this->faker->randomFloat(2, 0, 50000),
            'shipping_cost'      => $this->faker->randomFloat(2, 10000, 30000),
            'order_status'       => $this->faker->randomElement(['paid','shipped','delivered','cancelled']),
            'expedition'         => $this->faker->randomElement(['JNE','J&T','SiCepat']),
            'shipping_receipt'   => strtoupper(Str::random(12)),
            'note'               => $this->faker->sentence(),
            'coupon'             => [$this->faker->word, $this->faker->word],
            'admin_fee'          => $this->faker->randomFloat(2, 1000, 5000),
            'vat'                => $this->faker->randomFloat(2, 1000, 7000),
            'total'              => $this->faker->randomFloat(2, 15000, 2000000),
            'payment_type'       => $this->faker->randomElement(['ovo','gopay','transfer']),
        ];
    }
}
