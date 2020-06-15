<?php

use App\Level;
use Illuminate\Database\Seeder;

class LevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Level::insert([
            ['name' => 'Screen Interview'],
            ['name' => 'First Technical'],
            ['name' => 'Second Technical'],
            ['name' => 'HR Interview'],
            ['name' => 'Final Interview'],
        ]);
    }
}
