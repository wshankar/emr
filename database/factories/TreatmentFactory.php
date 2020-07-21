<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use App\Treatment;
use Faker\Generator as Faker;

$factory->define(Treatment::class, function (Faker $faker) {
    return [
        'prescription' => $faker->paragraphs(rand(3, 7), true),
        'fees' => rand(5000, 10000),
    ];
});
