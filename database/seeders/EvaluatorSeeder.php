<?php

namespace Database\Seeders;

use App\Models\Evaluator;
use Illuminate\Database\Seeder;

class EvaluatorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Evaluator::factory()
            ->count(5)
            ->create();
    }
}
