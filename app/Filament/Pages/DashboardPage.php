<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\DashboardOverview;
use App\Filament\Widgets\EvaluatorListOverview;
use App\Filament\Widgets\StatsOverview;
use App\Filament\Widgets\StudentListOverview;
use App\Filament\Widgets\SupervisorListOverview;
use App\Models\User;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Auth;

class DashboardPage extends Page
{
    // ...
    protected static ?string $slug = 'dashboard';

    protected static ?string $navigationIcon = 'heroicon-o-home';

    protected static ?int $navigationSort = -2;

    protected static string $view = 'filament::pages.dashboard';

    protected int | string | array $columnSpan = 'full';

    protected function getColumns(): int | array{
        return 2;
    }

    protected function getWidgets(): array
    {
        if (Auth::user()->hasRole('Student')) {

            //Condition check

            $user = Auth::user();
            return [];
        } else if (Auth::user()->hasRole('Supervisor')) {

            //Condition check
            $user = Auth::user();
            return [StudentListOverview::class];
        } else if (Auth::user()->hasRole('Evaluator')) {

            //Condition check
            $user = Auth::user();
            return [StudentListOverview::class];
        } else if (Auth::user()->hasRole('Coordinator')) {

            //Condition check
            $user = Auth::user();
            return [StudentListOverview::class, SupervisorListOverview::class, EvaluatorListOverview::class];
        } else if (Auth::user()->hasRole('Super Admin')) {

            //Condition check
            $user = Auth::user();
            return [StudentListOverview::class, SupervisorListOverview::class, EvaluatorListOverview::class];
        }

        return [StudentListOverview::class, SupervisorListOverview::class, EvaluatorListOverview::class];
    }
}
