<?php

namespace App\Filament\Resources\PostResource\Pages;

use Filament\Resources\Pages\ViewRecord;
use App\Filament\Resources\PostResource;
use App\Models\User;

class ViewPost extends ViewRecord
{
    protected static string $resource = PostResource::class;

    // protected function getRedirectUrl(): string
    // {
    //     return $this->getResource()::getUrl('index');
    // }

}
