<?php

namespace YourVendor\LaravelReactAuth;

use Illuminate\Support\ServiceProvider;
use YourVendor\LaravelReactAuth\Console\InstallCommand;

class LaravelReactAuthServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../config/react-auth.php',
            'react-auth'
        );
    }

    public function boot(): void
    {
        $this->loadRoutesFrom(__DIR__ . '/../routes/auth.php');
        $this->loadMigrationsFrom(__DIR__ . '/../src/database/migrations');

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/react-auth.php' => config_path('react-auth.php'),
            ], 'react-auth-config');

            $this->publishes([
                __DIR__ . '/../resources/js' => resource_path('js/vendor/react-auth'),
                __DIR__ . '/../resources/css' => resource_path('css/vendor/react-auth'),
            ], 'react-auth-assets');

            $this->publishes([
                __DIR__ . '/../src/database/migrations' => database_path('migrations'),
            ], 'react-auth-migrations');

            $this->publishes([
                __DIR__ . '/../stubs' => base_path('stubs/react-auth'),
            ], 'react-auth-stubs');

            $this->commands([InstallCommand::class]);
        }
    }
}
