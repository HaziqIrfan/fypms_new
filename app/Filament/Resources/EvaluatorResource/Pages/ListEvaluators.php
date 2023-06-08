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
    use HasDescendingOrder;

    protected static string $resource = EvaluatorResource::class;

    // protected function getTableQuery(): Builder
    // {

    //     if (Auth::user()->hasRole('Supervisor')) {

    //         return Evaluator::where('user_id', auth()->user()->Students->id);
    //     }
    //     else if (Auth::user()->hasRole('Coordinator')||Auth::user()->hasRole('Super Admin')){
    //         return Evaluator::query();
    //     }
    // }
}
