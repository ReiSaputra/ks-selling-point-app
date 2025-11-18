<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Order;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(App\Order::class, function (Faker $faker) {

    return [
        'invoice_number'     => strtoupper(Str::random(10)),
        'marketplace_invoice'=> strtoupper(Str::random(10)),
        'channel'            => $faker->randomElement(['Shopee','Tokopedia','Lazada']),
        'subtotal'           => $faker->randomFloat(2, 10000, 1000000),
        'discount'           => $faker->randomFloat(2, 0, 50000),
        'shipping_cost'      => $faker->randomFloat(2, 10000, 30000),
        'order_status'       => $faker->randomElement(['paid','shipped','delivered','cancelled']),
        'expedition'         => $faker->randomElement(['JNE','J&T','SiCepat']),
        'shipping_receipt'   => strtoupper(Str::random(12)),
        'note'               => $faker->sentence(),
        'coupon'             => [$faker->word, $faker->word],
        'admin_fee'          => $faker->randomFloat(2, 1000, 5000),
        'vat'                => $faker->randomFloat(2, 1000, 7000),
        'total'              => $faker->randomFloat(2, 15000, 2000000),
        'payment_type'       => $faker->randomElement(['ovo','gopay','transfer']),
    ];
});

