<?php

namespace Database\Factories;

use App\Models\Student;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class StudentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Student::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'sv_name' => $this->faker->text(255),
            'project_title' => $this->faker->text(255),
            'psm_status' => $this->faker->text(255),
            'year' => $this->faker->text(255),
            'program' => $this->faker->text(255),
            'pa_name' => $this->faker->text(255),
            'user_id' => \App\Models\User::factory(),
        ];
    }
}
