<?php

namespace App\Filament\Resources\LogbookResource\Pages;

use Filament\Resources\Pages\ListRecords;
use App\Filament\Traits\HasDescendingOrder;
use App\Filament\Resources\LogbookResource;
use App\Models\Logbook;
use App\Models\Student;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class ListLogbooks extends ListRecords
{
    use HasDescendingOrder;

    protected static string $resource = LogbookResource::class;

    protected function getTableQuery(): Builder
    {

        if (Auth::user()->hasRole('Student')) {

            return Logbook::whereHas('student', function ($q) {
                $q->where('user_id', auth()->user()->id);
            });
        } else if (Auth::user()->hasRole('Supervisor')) {
            return Logbook::whereHas('student', function ($q) {
                $q->where('supervisor_id', auth()->user()->Supervisors->id);
            });
        } else if (Auth::user()->hasRole('Coordinator') || Auth::user()->hasRole('Super Admin')) {
            return Logbook::query();
        }
    }
}
