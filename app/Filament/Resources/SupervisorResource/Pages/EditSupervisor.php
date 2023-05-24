<?php

namespace App\Filament\Resources\SupervisorResource\Pages;

use Filament\Resources\Pages\EditRecord;
use App\Filament\Resources\SupervisorResource;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class EditSupervisor extends EditRecord
{
    protected static string $resource = SupervisorResource::class;

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        $record->user()->update($data['user']); //update data by searching 'user()'

        return $record;
    }

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
