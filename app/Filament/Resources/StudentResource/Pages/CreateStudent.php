<?php

namespace App\Filament\Resources\StudentResource\Pages;

use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\StudentResource;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CreateStudent extends CreateRecord
{
    protected static string $resource = StudentResource::class;

    protected function handleRecordCreation(array $data): Model
    {
        return DB::transaction(function () use ($data) { //DB::transaction(function () use ($data) = to reset back to the previous db
            $user = User::create($data['user']); //create user 
            $user->assignRole('Student');
            return $user->student()->create($data); //create student 
        });
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
