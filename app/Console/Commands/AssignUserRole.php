<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Spatie\Permission\Models\Role;

class AssignUserRole extends Command
{
    // Define the signature with arguments: man_number and role_name
    protected $signature = 'user:assign-role {man_no} {role}';

    protected $description = 'Assign a specific Spatie role to a user by their Man Number';

    public function handle()
    {
        $manNo = $this->argument('man_no');
        $roleName = $this->argument('role');

        // 1. Find User
        $user = User::where('man_no', $manNo)->first();
        if (!$user) {
            $this->error("User with Man Number {$manNo} not found.");
            return 1;
        }

        // 2. Find Role
        $role = Role::where('name', $roleName)->first();
        if (!$role) {
            $this->error("Role '{$roleName}' does not exist.");
            return 1;
        }

        // 3. Assign Role
        $user->assignRole($role);

        $this->info("Successfully assigned '{$roleName}' to {$user->name} (Man No: {$manNo}).");
        return 0;
    }
}