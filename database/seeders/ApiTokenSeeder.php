<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class ApiTokenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $user = User::where('man_no', '72699')
            // ->where('con_st_code', 'ACT')
            ->first();

        $token = $user->createToken('MyApp')->plainTextToken;
        //dd($token);
    }
}
