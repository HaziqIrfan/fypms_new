<?php

namespace App\Filament\Resources\EvaluatorResource\Pages;

use Filament\Resources\Pages\ListRecords;
use App\Filament\Traits\HasDescendingOrder;
use App\Filament\Resources\EvaluatorResource;
use App\Models\Evaluator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class ListEvaluators extends ListRecords
{
    protected static string $resource = EvaluatorResource::class;

    // protected function getTableQuery(): Builder
    // {

    //     $query = Evaluator::query();

    //     if (Auth::user()->hasRole('Supervisor')) {
    //         $query->where('user_id', auth()->user()->supervisor->id);
    //     }
    
    //     return $query;
    // }
}
