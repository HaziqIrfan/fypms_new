<?php

namespace App\Filament\Resources\SupervisorResource\Pages;

use Filament\Resources\Pages\ListRecords;
use App\Filament\Traits\HasDescendingOrder;
use App\Filament\Resources\SupervisorResource;

class ListSupervisors extends ListRecords
{
    use HasDescendingOrder;

    protected static string $resource = SupervisorResource::class;
}
