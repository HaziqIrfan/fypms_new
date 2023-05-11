<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use App\Models\StudentSubmission;
use Illuminate\Database\Eloquent\Factories\Factory;

class StudentSubmissionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = StudentSubmission::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'file_path' => $this->faker->text(),
            'submission_id' => \App\Models\Submission::factory(),
            'student_id' => \App\Models\Student::factory(),
        ];
    }
}
