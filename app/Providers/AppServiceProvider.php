<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;

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
        // Fix for older MySQL versions
        Schema::defaultStringLength(191);

        // Share new assignments count with all views (students only)
        View::composer('*', function ($view) {
            if (Auth::check() && Auth::user()->role === 'student') {
                $user = Auth::user();

                $newAssignmentsCount = $user->assignments()
                    ->wherePivot(
                        'created_at',
                        '>',
                        $user->assignments_last_seen_at ?? now()->subYears(5)
                    )
                    ->count();

                $view->with('newAssignmentsCount', $newAssignmentsCount);
            }
        });
    }
}
