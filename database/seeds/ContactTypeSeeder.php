<?php

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
        if(!App\ContactType::whereIn('type',array('phone', 'email', 'linkedIn'))->get())
        App\ContactType::insert([
            ['type' => 'phone'],
            ['type' => 'email'],
            ['type' => 'linkedIn'],
        ]);
    }
}
