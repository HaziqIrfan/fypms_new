<?php

namespace App\Filament\Resources\StudentSubmissionResource\Pages;

use Filament\Resources\Pages\ListRecords;
use App\Filament\Traits\HasDescendingOrder;
use App\Filament\Resources\StudentSubmissionResource;

class ListStudentSubmissions extends ListRecords
{
    protected static string $resource = StudentSubmissionResource::class;
}
