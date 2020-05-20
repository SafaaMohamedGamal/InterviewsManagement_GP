<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(App\Interview::class, function (Faker $faker) {
    return [
        'application_id'   => $faker->numberBetween($min = 1, $max = 100),
        'emp_id'   => $faker->numberBetween($min = 1, $max = 100),
        'level_id'   => $faker->numberBetween($min = 1, $max = 100),
        'date'=> $faker->dateTime($max = 'now', $timezone = null),
        'seeker_review'=> $faker->paragraph,
        'company_review'=> $faker->paragraph,
        'zoom'=> $faker->paragraph


    ];
});