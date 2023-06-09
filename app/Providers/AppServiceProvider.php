<?php

namespace App\Providers;

use Filament\Facades\Filament;
use Filament\Navigation\UserMenuItem;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Filament::serving(function () {
            // Using Vite
            Filament::registerViteTheme('resources/css/filament.css');
            Filament::registerUserMenuItems([
                UserMenuItem::make()
                    ->label(auth()->check() ? auth()->user()->roles_name : "")
                    // ->url(route('filament.pages.settings'))
                    ->icon(''),
            ]);
        });
    }
}
