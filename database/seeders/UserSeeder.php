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
            'username' => 'nang3007',
            'password' => Hash::make('password'),
            'name' => 'Nang Tran Xuan',
            'email' => 'nang3007@gmail.com',
            'phone_number' => '0333501404',
            'role' => 3,
        ]);
        User::factory()->count(50)->create();

    }
}
