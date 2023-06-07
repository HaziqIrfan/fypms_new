<?php

namespace App\Filament\Widgets;

use App\Models\Evaluator;
use Filament\Widgets\StatsOverviewWidget\Card;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class EvaluatorListOverview extends BaseWidget
{
    protected function getCards(): array
    {
        return [
            Card::make('Total Evaluator', Evaluator::count())
                // ->description('32k increase')
                // ->descriptionIcon('heroicon-s-trending-up')
                // ->color('success'),
        ];
    }
}
