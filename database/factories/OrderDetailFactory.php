<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\OrderDetail;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(App\OrderDetail::class, function (Faker $faker) {

    return [
        'product_sku'  => strtoupper(Str::random(8)),
        'price'        => $faker->randomFloat(2, 10000, 100000),
        'actual_price' => $faker->randomFloat(2, 10000, 100000),
        'product_cost' => $faker->randomFloat(2, 5000, 80000),
        'quantity'     => $faker->numberBetween(1,5),
        'subtotal'     => $faker->randomFloat(2, 20000, 300000),
    ];
});

