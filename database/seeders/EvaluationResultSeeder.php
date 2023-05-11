<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\EvaluationResult;

class EvaluationResultSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        EvaluationResult::factory()
            ->count(5)
            ->create();
    }
}
