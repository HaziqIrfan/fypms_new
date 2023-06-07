<?php

namespace App\Filament\Widgets;

use App\Models\Supervisor;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;

class SupervisorListOverview extends BaseWidget
{
    protected function getCards(): array
    {
        return [
            Card::make('Total Supervisor', Supervisor::count())
                // ->description('32k increase')
                // ->descriptionIcon('heroicon-s-trending-up')
                // ->color('success'),
        ];
    }
}
