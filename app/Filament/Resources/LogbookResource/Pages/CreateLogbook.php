<?php

namespace App\Filament\Resources\LogbookResource\Pages;

use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\LogbookResource;
use App\Models\Logbook;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CreateLogbook extends CreateRecord
{
    protected static string $resource = LogbookResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['student_id'] = auth()->user()->student->id;//sepcific logbook student
        return $data;
    }

    }
