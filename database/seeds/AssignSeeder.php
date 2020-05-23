<?php

use Illuminate\Database\Seeder;
use App\User;

class AssignSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::where('userable_type', 'App\Seeder')->get();
        foreach ($users as $user) {
            $user->assignRole('seeker');
        }

        $users = User::where('userable_type', 'App\Employee')->get();
        foreach ($users as $user) {
            $user->assignRole('employee');
        }
    }
}
