<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Course>
 */
class CourseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        $courses = ['HTML', 'CSS', 'JavaScript', 'MariaDB', 'MySQL', 'Sequelize'];

        return [
            'name' => fake()->unique()->randomElement($courses),
            'category' => fake()->randomElement(['Frontend', 'Backend']),
            'description' => fake()->paragraph(6),
            'start_date' => fake()->dateTimeThisMonth(),
            'end_date' => fake()->dateTimeInInterval('+90 days', '+30 days'),
        ];
    }
}
