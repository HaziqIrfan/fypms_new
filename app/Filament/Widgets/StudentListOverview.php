<?php

namespace App\Filament\Widgets;

use App\Models\Student;
use App\Models\Supervisor;
use Filament\Widgets\StatsOverviewWidget\Card;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Illuminate\Support\Facades\Auth;

class StudentListOverview extends BaseWidget
{
    protected function getCards(): array
    {
        if (Auth::user()->hasRole('Supervisor')) {
            return [
                Card::make('Total Students', Student::where('supervisor_id', auth()->user()->Supervisors->id)->count())

            ];
        } else if (Auth::user()->hasRole('Coordinator') || Auth::user()->hasRole('Super Admin')) {
            return [
                Card::make('Total Students', Student::count())

            ];
        }else if (Auth::user()->hasRole('Evaluator')) {
            return [
                Card::make('Total Students', Student::wherehas('evaluators', function($q){
                    $q->where('evaluators_id', auth()->user()->id);
                })->count())

            ];
        }
    }
}
