<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\JobRequirement;
use Faker\Generator as Faker;

$factory->define(JobRequirement::class, function (Faker $faker) {
    return [
        'name'=>$faker->sentence(5),
    ];
});
