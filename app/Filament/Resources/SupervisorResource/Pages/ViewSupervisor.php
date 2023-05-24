<?php

namespace App\Filament\Resources\SupervisorResource\Pages;

use Filament\Resources\Pages\ViewRecord;
use App\Filament\Resources\SupervisorResource;
use App\Models\User;

class ViewSupervisor extends ViewRecord
{
    protected static string $resource = SupervisorResource::class;

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
