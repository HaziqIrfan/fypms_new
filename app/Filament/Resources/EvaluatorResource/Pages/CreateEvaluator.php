<?php

namespace App\Filament\Resources\EvaluatorResource\Pages;

use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\EvaluatorResource;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class CreateEvaluator extends CreateRecord
{

    protected static string $resource = EvaluatorResource::class;

    protected function handleRecordCreation(array $data): Model
    {
        $user = User::create($data['user']); //create user 

        return $user->evaluator()->create(); //create evaluator 
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
