<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;
use App\Models\Peminjaman;
use Carbon\Carbon;

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
        // Share notification data with user layout
        View::composer('layouts.user', function ($view) {
            $notifications = collect();
            if (Auth::check()) {
                $notifications = \App\Http\Controllers\PeminjamanController::getUserNotifications(Auth::user());
            }
            $view->with('userNotifications', $notifications);
        });
    }
}
