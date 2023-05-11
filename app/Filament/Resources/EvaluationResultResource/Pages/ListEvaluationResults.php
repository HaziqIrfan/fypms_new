<?php

namespace App\Filament\Resources\EvaluationResultResource\Pages;

use Filament\Resources\Pages\ListRecords;
use App\Filament\Traits\HasDescendingOrder;
use App\Filament\Resources\EvaluationResultResource;

class ListEvaluationResults extends ListRecords
{
    use HasDescendingOrder;

    protected static string $resource = EvaluationResultResource::class;
}
