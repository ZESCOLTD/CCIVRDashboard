<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use App\Models\User;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Find existing role or fail
        $adminRole = Role::where('name', 'admin')->firstOrFail();

        // Find existing user or fail
        $adminUser = User::where('man_no', '77336')->firstOrFail();

        // Assign the role to the user
        $adminUser->assignRole($adminRole);

        // Or by name
        // $adminUser->assignRole('admin');
    }
}
//php artisan db:seed --class=RoleSeeder
