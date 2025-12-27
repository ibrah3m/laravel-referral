<?php

namespace Ibrah3m\LaravelReferral\Providers;

use Illuminate\Support\ServiceProvider;

class ReferralServiceProvider extends ServiceProvider
{
    /**
     * Register package services.
     */
    public function register(): void
    {
        // Merge the package's configuration file with the application's configuration
        $this->mergeConfigFrom(__DIR__.'/../../config/referral.php', 'referral');
    }

    /**
     * Bootstrap package services.
     */
    public function boot(): void
    {
        // Load package migrations
        $this->loadMigrationsFrom(__DIR__.'/../../database/migrations');

        if ($this->app->runningInConsole()) {
            // Publish package's configuration file
            $this->publishes([
                __DIR__.'/../../config/referral.php' => config_path('referral.php'),
            ], 'laravel-referral-config');

            // Publish package's migration files
            $this->publishes([
                __DIR__.'/../../database/migrations' => database_path('migrations'),
            ], 'laravel-referral-migrations');
        }

        // Load package's routes
        $this->loadRoutesFrom(__DIR__.'/../../routes/web.php');
        
        // Bind the ReferralController to the application container
        $this->app->bind('Ibrah3m\LaravelReferral\Controllers\ReferralController', function ($app) {
            return new \Ibrah3m\LaravelReferral\Controllers\ReferralController();
        });
    }
}
