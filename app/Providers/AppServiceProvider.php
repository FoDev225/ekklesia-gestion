<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Http\Request;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator as Paginate;
use App\Models\Believer;
use App\Observers\BelieverObserver;

class AppServiceProvider extends ServiceProvider
{
    public const HOME = '/redirect-user';
    
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
        Paginate::useBootstrapFive();
        Believer::observe(BelieverObserver::class);

        RateLimiter::for('login', function (Request $request) {
            return Limit::perMinute(5)->by(
                strtolower($request->input('username', 'guest')).$request->ip());
        });
    }
}
