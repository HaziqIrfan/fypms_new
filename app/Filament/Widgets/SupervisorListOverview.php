<?php

namespace App\Filament\Widgets;

use App\Models\Supervisor;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;

class SupervisorListOverview extends BaseWidget
{
    protected int | string | array $columnSpan = '2';

    protected function getCards(): array
    {
        return [


        ];
    }
}
