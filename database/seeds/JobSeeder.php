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
        factory(App\Job::class, 10)->create()->each(function ($job) {
            $job->requirements()->save(factory(App\JobRequirement::class)->make());
        });
    }
}
