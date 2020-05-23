<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // // create permissions
        Permission::create(['name' => 'add job']);
        Permission::create(['name' => 'edit job']);
        Permission::create(['name' => 'delete job']);
        Permission::create(['name' => 'add seeker']);
        Permission::create(['name' => 'edit seeker']);
        Permission::create(['name' => 'delete seeker']);
        Permission::create(['name' => 'add employee']);
        Permission::create(['name' => 'edit employee']);
        Permission::create(['name' => 'delete employee']);
        Permission::create(['name' => 'add app']);
        Permission::create(['name' => 'delete app']);
        Permission::create(['name' => 'add review']);
        Permission::create(['name' => 'edit review']);
        Permission::create(['name' => 'delete review']);
        Permission::create(['name' => 'add interview']);
        Permission::create(['name' => 'edit interview']);
        Permission::create(['name' => 'delete interview']);


    }
}
