<?php

namespace App\Providers;

use App\Models\User;
use App\Observers\UserObserver;
use App\Services\RateService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(RateService::class, function ($app) {
            return new RateService(config('services.rate.url', 'http'));
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        User::observe(UserObserver::class);
    }
}
