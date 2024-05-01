<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['name' => 'Room A1'],
            ['name' => 'Room A2'],
            ['name' => 'Room A3'],
            ['name' => 'Room A4'],
            ['name' => 'Room A5'],
            ['name' => 'Room A6'],
            ['name' => 'Room A7'],
            ['name' => 'Room A8'],
            ['name' => 'Room A9'],
            ['name' => 'Room A10'],
            ['name' => 'Room A11'],
            ['name' => 'Room A12'],
            ['name' => 'Room A13'],
            ['name' => 'Room A14'],
            ['name' => 'Room A15'],
            ['name' => 'Room A16'],
            ['name' => 'Room A17'],
            ['name' => 'Room A18'],
            ['name' => 'Room A19'],
            ['name' => 'Room A20'],
            ['name' => 'Room A21'],
            ['name' => 'Room A22'],
            ['name' => 'Room A23'],
            ['name' => 'Room A24'],
            ['name' => 'Room A25'],
        ];
        DB::table('rooms')->insert($data);
    }
}
