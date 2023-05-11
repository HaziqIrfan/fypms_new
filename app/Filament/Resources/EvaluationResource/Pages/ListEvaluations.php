<?php

namespace App\Filament\Resources\EvaluationResource\Pages;

use Filament\Resources\Pages\ListRecords;
use App\Filament\Traits\HasDescendingOrder;
use App\Filament\Resources\EvaluationResource;

class ListEvaluations extends ListRecords
{
    use HasDescendingOrder;

    protected static string $resource = EvaluationResource::class;
}
