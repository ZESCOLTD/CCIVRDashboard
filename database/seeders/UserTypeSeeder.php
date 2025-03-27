<?php

namespace Database\Seeders;

use App\Models\UserType;
use Illuminate\Database\Seeder;

class UserTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        UserType::create([
            [
                'code' => 0,
                'name' => 'Standard User'
            ],
            [
                'code' => 1,
                'name' => 'Admin(view only)'
            ],
            [
                'code' => 2,
                'name' => 'Admin(view & edit only)'
            ],
            [
                'code' => 3,
                'name' => 'Admin(view, edit & block)'
            ],
            [
                'code' => 4,
                'name' => 'Admin(view, edit, block & create)'
            ],
        ]);
    }
}
