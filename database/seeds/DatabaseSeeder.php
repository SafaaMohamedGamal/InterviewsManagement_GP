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

        $this->call(PermissionSeeder::class);
        $this->call(RoleSeeder::class);
        $this->call(EmployeeSeeder::class);
        $this->call(SeekerSeeder::class);
        $this->call(AssignSeeder::class);
        $this->call(ContactTypeSeeder::class);
        $this->call(StatusSeeder::class);
        $this->call(JobSeeder::class);
        $this->call(ApplicationSeeder::class);
        $this->call(LevelSeeder::class);
        $this->call(InterviewsTableSeeder::class);
    }
}
