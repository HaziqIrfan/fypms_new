<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;

class DashboardOverview extends Widget
{
    protected static string $view = 'filament.widgets.dashboard-overview';
    protected int | string | array $columnSpan = [
        'md' => 2,
        'xl' => 3,
    ];
    protected function getColumns(): int | array
    {
        return 3;
    }
    
}
