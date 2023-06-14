<?php

namespace App\Filament\Resources\LogbookResource\Pages;

use Filament\Resources\Pages\ViewRecord;
use App\Filament\Resources\LogbookResource;
use App\Models\Logbook;

class ViewLogbook extends ViewRecord
{
    protected static string $resource = LogbookResource::class;

    protected function mutateFormDataBeforeFill(array $data): array
    {

        $data['user']['name'] = $this->record->student->user->name;
        $data['user']['matric_id'] = $this->record->student->user->matric_id;
        $data['student']['psm_status'] = $this->record->student->psm_status;

        return $data;
    }
}
