<?php

namespace App\Filament\Resources\StudentResource\Pages;

use Filament\Resources\Pages\ViewRecord;
use App\Filament\Resources\StudentResource;
use App\Models\User;

class ViewStudent extends ViewRecord
{
    protected static string $resource = StudentResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $data['user'] = User::find($data['user_id']);

        return $data;
    }
}
