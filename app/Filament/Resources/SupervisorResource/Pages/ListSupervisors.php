<?php

namespace App\Filament\Resources\SupervisorResource\Pages;

use Filament\Resources\Pages\ListRecords;
use App\Filament\Traits\HasDescendingOrder;
use App\Filament\Resources\SupervisorResource;
use App\Models\Student;
use App\Models\Supervisor;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class ListSupervisors extends ListRecords
{
    use HasDescendingOrder;

    protected static string $resource = SupervisorResource::class;

    protected function getTableQuery(): Builder
    {

        if (Auth::user()->hasRole('Student')) {

            return Supervisor::whereHas('students', function($q){
                $q->where('user_id', auth()->user()->id);
            });
        } else if (Auth::user()->hasRole('Coordinator') || Auth::user()->hasRole('Super Admin')) {
            return Supervisor::query();
        }
    }
}


// return Supervisor::wherehas('students', function($q){
//     $q->where('students_id', auth()->user()->id);
// }); 

// Card::make('Total Students', Student::wherehas('evaluators', function($q){
//     $q->where('evaluators_id', auth()->user()->id);
// })->count())