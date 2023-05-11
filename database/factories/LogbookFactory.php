<?php

namespace Database\Factories;

use App\Models\Logbook;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class LogbookFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Logbook::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'datetime' => $this->faker->dateTime(),
            'week' => $this->faker->text(255),
            'approval_date' => $this->faker->dateTime(),
            'description' => $this->faker->dateTime(),
            'comment' => $this->faker->text(),
            'student_id' => \App\Models\Student::factory(),
        ];
    }
}
