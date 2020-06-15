<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(App\Seeker::class, function (Faker $faker) {
    return [
        'phone' => $faker->e164PhoneNumber,
        'address'=>$faker->streetAddress,
        'city'=>$faker->randomElement(['Alexandria','Cairo','luxor']),
       'seniority'=>$faker->randomElement(['junior','senior','team leader','project manager']),
       'expYears'=>$faker->numberBetween(0, 15),
       'currentJob'=>$faker->jobTitle,
       'currentSalary'=>$faker->numberBetween(3000, 6000),
       'expectedSalary'=>$faker->numberBetween(5000, 10000),
       'isVerified'=>1
    ];
});
