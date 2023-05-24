<?php

namespace Database\Factories;

use App\Models\Supervisor;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class SupervisorFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Supervisor::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'background' => $this->faker->text(255),
            'availability' => $this->faker->text(255),
            'user_id' => \App\Models\User::factory(),
        ];
    }
}
