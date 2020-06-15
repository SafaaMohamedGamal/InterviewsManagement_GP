<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Job;
use Faker\Generator as Faker;

$factory->define(Job::class, function (Faker $faker) {
    return [
       'title'=>$faker->jobTitle,
       'description'=>$faker->sentence(40),
       'years_exp'=>$faker->numberBetween(0, 15),
       'seniority'=>$faker->randomElement(['Junior','Senior','Team leader','Project manager']),
       'available'=>1,
    ];
});
