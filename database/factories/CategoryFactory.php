<?php

use Faker\Generator as Faker;


$factory->define(App\Category::class, function (Faker $faker) {
    return [
        'name_categ' => $faker->name,
        'name_sub_categ' => $faker->name,
        'description' => $faker->name, 
    ];
});
