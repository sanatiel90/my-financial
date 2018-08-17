<?php

use Faker\Generator as Faker;


$factory->define(App\Expense::class, function (Faker $faker) {
    return [
        'value' => $faker->randomFloat(2, 10, 500),
        'description' => $faker->name,
        'data' => date('Y-m-d'),
        'category_id' => 1,
        'user_id' => 1
    ];
});
