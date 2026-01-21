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

            $url = config('services.rate.url') ?? 'https://api.exchangerate.host/latest';

            return new RateService($url);
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
