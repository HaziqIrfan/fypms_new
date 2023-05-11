<?php

namespace App\Filament\Resources\EvaluatorResource\Pages;

use Filament\Resources\Pages\ListRecords;
use App\Filament\Traits\HasDescendingOrder;
use App\Filament\Resources\EvaluatorResource;

class ListEvaluators extends ListRecords
{
    use HasDescendingOrder;

    protected static string $resource = EvaluatorResource::class;
}
