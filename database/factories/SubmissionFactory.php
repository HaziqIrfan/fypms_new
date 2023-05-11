<?php

namespace Database\Factories;

use App\Models\Submission;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class SubmissionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Submission::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(10),
            'description' => $this->faker->text(255),
            'due_date' => $this->faker->dateTime(),
            'start_date' => $this->faker->dateTime(),
        ];
    }
}
