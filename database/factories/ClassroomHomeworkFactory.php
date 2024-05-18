<?php

namespace Database\Factories;

use App\Models\Classroom;
use App\Models\Homework;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ClassroomHomework>
 */
class ClassroomHomeworkFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $classIds = Classroom::get()->pluck('id')->toArray();
        $homeworkIds = Homework::get()->pluck('id')->toArray();

        return [
            'classroom_id' => $this->faker->randomElement($classIds),
            'homework_id' => $this->faker->randomElement($homeworkIds),
        ];
    }
}
