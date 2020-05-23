<?php

use Illuminate\Database\Seeder;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Employee::class, 10)->create()->each(function ($employee) {
            $employee->user()->save(factory(App\User::class)->create());
        });
    }
}
