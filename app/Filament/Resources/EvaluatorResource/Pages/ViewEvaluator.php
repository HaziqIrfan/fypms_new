<?php

namespace App\Filament\Resources\EvaluatorResource\Pages;

use Filament\Resources\Pages\ViewRecord;
use App\Filament\Resources\EvaluatorResource;
use App\Models\User;

class ViewEvaluator extends ViewRecord
{
    protected static string $resource = EvaluatorResource::class;

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
