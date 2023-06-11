<?php

namespace App\Providers;

use Filament\Facades\Filament;
use Filament\Navigation\NavigationGroup;
use Filament\Navigation\UserMenuItem;
use Illuminate\Support\ServiceProvider;
// use Illuminate\Validation\Rules\Password;
// use JeffGreco13\FilamentBreezy\FilamentBreezy;
use Illuminate\Validation\Rules\Password;
use JeffGreco13\FilamentBreezy\FilamentBreezy;

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

        FilamentBreezy::setPasswordRules(
            [
                Password::min(8)
                    ->letters()
                    ->numbers()
                    ->mixedCase()
                    ->uncompromised(3)
            ]
        );
        // Filament::serving(function () {
        //     Filament::registerNavigationGroups([
        //         NavigationGroup::make()
        //              ->label('Shop')
        //              ->icon('heroicon-s-shopping-cart'),
        //         NavigationGroup::make()
        //             ->label('Blog')
        //             ->icon('heroicon-s-pencil'),
        //         NavigationGroup::make()
        //             ->label('Settings')
        //             ->icon('heroicon-s-cog')
        //             ->collapsed(),
        //     ]);
        // });
    }
    
}
