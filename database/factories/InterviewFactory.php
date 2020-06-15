<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Level;
use App\Model;
use App\Employee;
use App\Application;
use Faker\Generator as Faker;

$factory->define(App\Interview::class, function (Faker $faker) {
    return [
        'application_id'   => Application::all()->random()->id,
        'emp_id'   => Employee::all()->random()->id,
        'level_id'   => Level::all()->random()->id,
        'date'=> $faker->dateTimeBetween($startDate = '-1 years', $endDate = '+1 years', $timezone = null),
        'seeker_review'=> $faker->paragraph,
        'company_review'=> $faker->paragraph,
        'zoom'=> $faker->url
    ];
});