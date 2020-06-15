<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(App\Employee::class, function (Faker $faker) {
    return [
        'position'=>$faker->randomElement(['HR','Team Leader','Senior','CEO']),
        'branch'=>$faker->randomElement(['Alexandria','Caior','Saudi Arabia']),
    ];
});
