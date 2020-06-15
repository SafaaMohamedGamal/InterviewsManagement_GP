<?php

use App\ContactType;
use Illuminate\Database\Seeder;

class ContactTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ContactType::insert([
            ['type' => 'phone'],
            ['type' => 'email'],
            ['type' => 'linkedIn'],
        ]);
    }
}
