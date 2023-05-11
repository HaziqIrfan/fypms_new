<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Adding an admin user
        $user = \App\Models\User::factory()
            ->count(1)
            ->create([
                'email' => 'admin@admin.com',
                'password' => \Hash::make('admin'),
            ]);
        $this->call(PermissionsSeeder::class);

        $this->call(EvaluationSeeder::class);
        $this->call(EvaluationResultSeeder::class);
        $this->call(EvaluatorSeeder::class);
        $this->call(LogbookSeeder::class);
        $this->call(PostSeeder::class);
        $this->call(StudentSeeder::class);
        $this->call(StudentSubmissionSeeder::class);
        $this->call(SubmissionSeeder::class);
        $this->call(SupervisorSeeder::class);
        $this->call(UserSeeder::class);
    }
}
