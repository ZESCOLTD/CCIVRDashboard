<?php

namespace  Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserRolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // // Create Permissions
        // Permission::create(['name' => 'view role']);
        // Permission::create(['name' => 'create role']);
        // Permission::create(['name' => 'update role']);
        // Permission::create(['name' => 'delete role']);

        // Permission::create(['name' => 'view permission']);
        // Permission::create(['name' => 'create permission']);
        // Permission::create(['name' => 'update permission']);
        // Permission::create(['name' => 'delete permission']);

        // Permission::create(['name' => 'view user']);
        // Permission::create(['name' => 'create user']);
        // Permission::create(['name' => 'update user']);
        // Permission::create(['name' => 'delete user']);

        // Permission::create(['name' => 'view product']);
        // Permission::create(['name' => 'create product']);
        // Permission::create(['name' => 'update product']);
        // Permission::create(['name' => 'delete product']);


        // // Create Roles
        $superAdminRole = Role::firstOrCreate(['name' => 'super-admin']); //as super-admin
        $adminRole = Role::firstOrCreate(['name' => 'admin'], ['name' => 'admin']);
        $staffRole = Role::firstOrCreate(['name' => 'staff'], ['name' => 'staff']);
        $userRole = Role::firstOrCreate(['name' => 'user'], ['name' => 'user']);

        // Lets give all permission to super-admin role.
        $allPermissionNames = Permission::pluck('name')->toArray();

        $superAdminRole->givePermissionTo($allPermissionNames);

        // Let's give few permissions to admin role.
        $adminRole->givePermissionTo(['create role', 'view role', 'update role']);
        $adminRole->givePermissionTo(['create permission', 'view permission']);
        $adminRole->givePermissionTo(['create user', 'view user', 'update user']);
        $adminRole->givePermissionTo(['create product', 'view product', 'update product']);


        // Let's Create User and assign Role to it.

        $superAdminUser = User::firstOrCreate([
            //'email' => 'superadmin@gmail.com',
            'man_no' => '72699'
        ], [
            'name' => 'Super Admin',
            'man_no' => '72699',
            'email' => 'kkinyama@zesco.co.zm',
            'password' => Hash::make('welcome123'),
        ]);

        $superAdminUser->assignRole($superAdminRole);


        $adminUser = User::firstOrCreate([
            //  'email' => 'admin@gmail.com'
            'man_no' => '72699'
        ], [
            //'name' => 'Admin',
            'man_no' => '72699',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('welcome123'),
        ]);

        $adminUser->assignRole($adminRole);


        $staffUser = User::firstOrCreate([
            'email' => 'staff@gmail.com',
        ], [
            'name' => 'Staff',
            'email' => 'staff@gmail.com',
            'password' => Hash::make('12345678'),
        ]);

        $staffUser->assignRole($staffRole);
    }
}
