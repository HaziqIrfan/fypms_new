<?php

namespace Database\Seeders;

use App\Models\Logbook;
use Illuminate\Database\Seeder;

class LogbookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Logbook::factory()
            ->count(5)
            ->create();
    }
}
