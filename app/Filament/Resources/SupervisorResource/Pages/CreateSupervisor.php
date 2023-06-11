<?php

namespace App\Filament\Resources\SupervisorResource\Pages;

use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\SupervisorResource;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CreateSupervisor extends CreateRecord
{
    protected static string $resource = SupervisorResource::class;

    protected function handleRecordCreation(array $data): Model
    {
        return DB::transaction(function () use ($data) { //DB::transaction(function () use ($data) = to reset back to the previous db
            $user = User::create($data['user']); //create user 
            $user->assignRole('Supervisor');
            $user->evaluator()->create();
            $user->assignRole('Evaluator');
            if ($data['is_coordinator']) {
                $user->assignRole('Coordinator');
            }
            return $user->supervisors()->create($data); //create sv 
        });
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
