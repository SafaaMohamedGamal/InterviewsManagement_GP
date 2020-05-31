<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        // $this->call(EmployeeSeeder::class);
        // $this->call(SeekerSeeder::class);
        // $this->call(PermissionSeeder::class);
        // $this->call(RoleSeeder::class);
        // $this->call(AssignSeeder::class);
        // $this->call(ContactTypeSeeder::class);
<<<<<<< HEAD
        $this->call(StatusSeeder::class);
        $this->call(JobSeeder::class);
        $this->call(ApplicationSeeder::class);
=======
>>>>>>> eadfb5dcc1c4db7737fc5f1a008e1a992d3b148b

        // $this->call(StatusSeeder::class);
        $this->call(JobSeeder::class);
        $this->call(InterviewsTableSeeder::class);
    }
}
