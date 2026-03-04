<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Spatie\Permission\Models\Role;

class AssignUserRole extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:assign-role {man_no} {role}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Assign a specific Spatie role to a user by their Man Number, creating the role if it does not exist.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $manNo = $this->argument('man_no');
        $roleName = $this->argument('role');

        // 1. Find the User
        $user = User::where('man_no', $manNo)->first();

        if (!$user) {
            $this->error("User with Man Number [{$manNo}] not found in the database.");
            return 1;
        }

        // 2. Find or Create the Role
        // This prevents the "Role does not exist" error by creating it on the fly
        $role = Role::firstOrCreate(['name' => $roleName, 'guard_name' => 'web']);

        if ($role->wasRecentlyCreated) {
            $this->warn("Role '{$roleName}' did not exist and has been created.");
        }

        // 3. Check if user already has the role to avoid redundant logs
        if ($user->hasRole($roleName)) {
            $this->info("User {$user->name} already has the '{$roleName}' role.");
            return 0;
        }

        // 4. Assign the Role
        try {
            $user->assignRole($role);
            $this->info("Successfully assigned '{$roleName}' to {$user->name} (Man No: {$manNo}).");
        } catch (\Exception $e) {
            $this->error("An error occurred: " . $e->getMessage());
            return 1;
        }

        return 0;
    }
}