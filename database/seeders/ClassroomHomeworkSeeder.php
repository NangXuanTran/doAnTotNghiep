<?php

namespace Database\Seeders;

use App\Models\ClassroomHomework;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ClassroomHomeworkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ClassroomHomework::factory()->count(50)->create();
    }
}
