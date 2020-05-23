<?php

use Illuminate\Database\Seeder;

class SeekerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Seeker::class, 10)->create()->each(function ($seeker) {
            $seeker->user()->save(factory(App\User::class)->create());
        });
    }
}
