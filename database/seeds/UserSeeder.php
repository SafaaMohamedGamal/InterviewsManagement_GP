<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class UserSeeder extends Seeder
{
    /**
     * Create the initial roles and permissions.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // // create permissions
        // Permission::create(['name' => 'edit articles']);
        // Permission::create(['name' => 'delete articles']);
        // Permission::create(['name' => 'publish articles']);
        // Permission::create(['name' => 'unpublish articles']);
        //
        // // create roles and assign existing permissions
        // $role1 = Role::create(['name' => 'writer']);
        // $role1->givePermissionTo('edit articles');
        // $role1->givePermissionTo('delete articles');
        //
        // $role2 = Role::create(['name' => 'admin']);
        // $role2->givePermissionTo('publish articles');
        // $role2->givePermissionTo('unpublish articles');

        $adminRole = Role::create(['name' => 'super-admin']);
        $seekerRole = Role::create(['name' => 'seeker']);
        $employeeRole = Role::create(['name' => 'employee']);
        // gets all permissions via Gate::before rule; see AuthServiceProvider

        // create demo users
        $user = Factory(App\User::class)->create([
            'name' => 'superadmin',
            'email' => 'superadmin@gmail.com',
            'password' => '12345678',
        ]);
        $user->assignRole($adminRole);

        $user1 = Factory(App\User::class)->create([
            'name' => 'user1',
            'email' => 'user1@gmail.com',
            'password' => '12345678',
        ]);
        // $user->assignRole($role2);

        $user2 = Factory(App\User::class)->create([
            'name' => 'user2',
            'email' => 'user2@gmail.com',
            'password' => '12345678',
        ]);
        // $user->assignRole($role3);
    }
}
