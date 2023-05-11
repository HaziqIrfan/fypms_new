<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use App\Models\EvaluationResult;
use Illuminate\Database\Eloquent\Factories\Factory;

class EvaluationResultFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = EvaluationResult::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'mark' => $this->faker->text(255),
            'evaluation_id' => \App\Models\Evaluation::factory(),
            'student_id' => \App\Models\Student::factory(),
            'evaluator_id' => \App\Models\Evaluator::factory(),
        ];
    }
}
