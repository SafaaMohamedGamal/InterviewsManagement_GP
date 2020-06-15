<?php

use App\Job;
use App\JobRequirement;
use Illuminate\Database\Seeder;
use PharIo\Manifest\Requirement;

class JobSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Job::class, 30)->create()->each(function ($job) {
            $job->requirements()->saveMany(factory(App\JobRequirement::class,3)->make());
        });
    }
}
