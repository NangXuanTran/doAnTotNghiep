<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'password' => Hash::make('password'),
            'name' => 'Nang STUDENT',
            'email' => 'nang30073@gmail.com',
            'phone_number' => '0333501404',
            'role' => 3,
        ]);

        DB::table('users')->insert([
            'password' => Hash::make('password'),
            'name' => 'Nang ADMIN',
            'email' => 'nang30071@gmail.com',
            'phone_number' => '0333501404',
            'role' => 1,
        ]);

        DB::table('users')->insert([
            'password' => Hash::make('password'),
            'name' => 'Nang TEACHER',
            'email' => 'nang30072@gmail.com',
            'phone_number' => '0333501404',
            'role' => 2,
        ]);
        User::factory()->count(50)->create();

    }
}
