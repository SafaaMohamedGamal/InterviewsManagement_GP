<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Job;
use App\Seeker;
use App\AppStatus;
use App\Application;
use Faker\Generator as Faker;

$factory->define(Application::class, function (Faker $faker) {
    return [
        'seeker_id'=>Seeker::all()->random()->id,
        'job_id'=>Job::all()->random()->id,
        'appstatus_id'=>AppStatus::newStatus()->id,
    ];
});
