<?php

namespace App\Filament\Widgets;

use App\Models\Evaluator;
use App\Models\Student;
use App\Models\Supervisor;
use Filament\Widgets\StatsOverviewWidget\Card;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Illuminate\Support\Facades\Auth;

class StudentListOverview extends BaseWidget
{
    protected function getCards(): array
    {
        if (Auth::user()->hasRole('Student')) {

            return [];
        } else if (Auth::user()->hasRole('Supervisor')) {

            return [
                Card::make('Total Students', Student::where('supervisor_id', auth()->user()->Supervisors->id)->count())

            ];
        } else if (Auth::user()->hasRole('Evaluator')) {
            return [
                Card::make('Total Students', Student::wherehas('evaluators', function ($q) {
                    $q->where('evaluators_id', auth()->user()->id);
                })->count())

            ];
        } else if (Auth::user()->hasRole('Coordinator')) {

            return [
                Card::make('Total Students', Student::count()),
                Card::make('Total Supervisor', Supervisor::count()),
                Card::make('Total Evaluator', Evaluator::count()),

            ];
        } else if (Auth::user()->hasRole('Super Admin')) {
            return [
                Card::make('Total Students', Student::count())
                    ->description('This is total students')
                    ->color('primary')
                    ->descriptionIcon('heroicon-s-user-group'),

                Card::make('Total Supervisor', Supervisor::count())
                    ->description('This is total Supervisors')
                    ->color('primary')
                    ->descriptionIcon('heroicon-s-academic-cap'),

                Card::make('Total Evaluator', Evaluator::count())
                    ->description('This is total Supervisors')
                    ->descriptionIcon('heroicon-s-academic-cap')
                    ->color('danger'),
            ];
        }
    }
}
