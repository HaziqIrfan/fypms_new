<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\StudentSubmission;

class StudentSubmissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        StudentSubmission::factory()
            ->count(5)
            ->create();
    }
}
