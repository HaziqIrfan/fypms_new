<?php

namespace App\Filament\Resources\LogbookResource\Pages;

use Filament\Resources\Pages\ListRecords;
use App\Filament\Traits\HasDescendingOrder;
use App\Filament\Resources\LogbookResource;

class ListLogbooks extends ListRecords
{
    use HasDescendingOrder;

    protected static string $resource = LogbookResource::class;
}
