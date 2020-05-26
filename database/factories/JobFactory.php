<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Job;
use Faker\Generator as Faker;

$factory->define(Job::class, function (Faker $faker) {
    return [
       'title'=>$faker->jobTitle,
       'description'=>$faker->sentence(6),
       'years_exp'=>$faker->numberBetween(0, 15),
       'seniority'=>$faker->randomElement(['junior','senior','team leader','project manager']),
       'available'=>1,
    ];
});
