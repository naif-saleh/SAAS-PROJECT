<?php

namespace App\Providers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Share current team with all views
        View::composer('*', function ($view) {
            if (Auth::check()) {
                $view->with('currentTeam', Auth::user()->currentTeam());
                $view->with('userTeams', Auth::user()->teams()->get());
            }
        });
    }
}
