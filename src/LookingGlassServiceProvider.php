<?php

namespace Cxj\LookingGlass;

use Cxj\LookingGlass\Console\Commands\RunHealthChecksCommand;
use Illuminate\Foundation\Console\AboutCommand;
use Illuminate\Support\ServiceProvider;

class LookingGlassServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     */
    public function boot(): void
    {
        // $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'cxj');
        // $this->loadViewsFrom(__DIR__.'/../resources/views', 'cxj');
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
        $this->loadRoutesFrom(__DIR__ . '/routes.php');

        // Publishing is only necessary when using the CLI.
        if ($this->app->runningInConsole()) {
            $this->bootForConsole();
        }

        AboutCommand::add('Looking Glass', fn () => ['Version' => '0.0.2']);
    }

    /**
     * Register any package services.
     */
    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../config/looking-glass.php',
            'looking-glass'
        );

        // Register the service the package provides.
        $this->app->singleton('looking-glass', function ($app) {
            return new LookingGlassServiceProvider($app);
        });
    }

    /**
     * Get the services provided by the provider.
     */
    public function provides(): array
    {
        return ['looking-glass'];
    }

    /**
     * Console-specific booting.
     */
    protected function bootForConsole(): void
    {
        // Publishing the configuration file.
        $this->publishes([
            __DIR__ . '/../config/looking-glass.php' => config_path(
                'looking-glass.php'
            ),
        ], 'looking-glass.config');

        // Publishing the views.
        /*$this->publishes([
            __DIR__.'/../resources/views' => base_path('resources/views/vendor/cxj'),
        ], 'looking-glass.views');*/

        // Publishing assets.
        /*$this->publishes([
            __DIR__.'/../resources/assets' => public_path('vendor/cxj'),
        ], 'looking-glass.views');*/

        // Publishing the translation files.
        /*$this->publishes([
            __DIR__.'/../resources/lang' => resource_path('lang/vendor/cxj'),
        ], 'looking-glass.views');*/

        // Registering package commands.
        $this->commands([
            RunHealthChecksCommand::class,
        ]);
    }
}
