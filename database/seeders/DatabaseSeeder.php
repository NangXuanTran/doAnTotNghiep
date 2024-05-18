<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            RoomSeeder::class,
            ClassroomSeeder::class,
            ClassroomStudentSeeder::class,
            ExamSeeder::class,
            LessonSeeder::class,
            AttendanceSeeder::class,
            NotificationSeeder::class,
            ExamResultSeeder::class,
            ClassroomRoomSeeder::class,
            HomeworkSeeder::class,
            HomeworkResultSeeder::class,
            QuestionSeeder::class,
            DocumentSeeder::class,
            DocumentLessonSeeder::class,
            HomeworkQuestionSeeder::class,
            // ClassroomHomeworkSeeder::class,
        ]);
    }
}
