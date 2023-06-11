<?php

namespace App\Filament\Resources\StudentResource\Pages;

use Filament\Resources\Pages\ListRecords;
use App\Filament\Traits\HasDescendingOrder;
use App\Filament\Resources\StudentResource;
use App\Models\Student;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class ListStudents extends ListRecords
{
    protected static string $resource = StudentResource::class;

    protected function getTableQuery(): Builder
    {

        if (Auth::user()->hasRole('Coordinator') || Auth::user()->hasRole('Super Admin')) {
            return Student::query();
        } else if (Auth::user()->hasRole('Supervisor')) {

            return Student::where('supervisor_id', auth()->user()->Supervisors->id);
        }
    }
}
