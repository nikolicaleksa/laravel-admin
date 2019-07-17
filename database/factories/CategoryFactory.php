<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Category;
use Faker\Generator as Faker;

$factory->define(Category::class, function (Faker $faker) {
    $created_at = $faker->dateTimeBetween('-2 months', '-1 month');

    return [
        'name' => $faker->text(24),
        'created_at' => $created_at,
        'updated_at' => $created_at,
    ];
});
