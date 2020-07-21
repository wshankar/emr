<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use App\Patient;
use Faker\Generator as Faker;

$factory->define(Patient::class, function (Faker $faker) {
    $gender = $faker->randomElements(['male', 'female'])[0];
    return [
        'name' => $faker->name($gender),
        'age' => rand(1, 100),
        'gender' => $gender,
        'address' => $faker->address,
        'phone' => $faker->phoneNumber,
        'fatherName' => $faker->name,
    ];
});
