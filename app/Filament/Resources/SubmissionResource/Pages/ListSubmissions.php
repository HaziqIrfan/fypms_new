<?php

namespace App\Filament\Resources\SubmissionResource\Pages;

use Filament\Resources\Pages\ListRecords;
use App\Filament\Traits\HasDescendingOrder;
use App\Filament\Resources\SubmissionResource;

class ListSubmissions extends ListRecords
{
    protected static string $resource = SubmissionResource::class;
}
