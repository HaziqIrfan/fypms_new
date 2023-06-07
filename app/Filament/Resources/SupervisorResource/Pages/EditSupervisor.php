<?php

namespace App\Filament\Resources\SupervisorResource\Pages;

use Filament\Resources\Pages\EditRecord;
use App\Filament\Resources\SupervisorResource;
use App\Models\User;
use Filament\Pages\Actions\DeleteAction;
use Illuminate\Database\Eloquent\Model;

class EditSupervisor extends EditRecord
{
    protected static string $resource = SupervisorResource::class;

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        $record->user()->update($data['user']); //update data by searching 'user()'
        $record->update($data);//update data
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

    protected function getActions(): array
    {
        return [
            DeleteAction::make()->before(
                function (DeleteAction $action, Model $record,) {

                    // delete user
                    $record->user()->forceDelete();

                }
            ),
        ];
    }
}
