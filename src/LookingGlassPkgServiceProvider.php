<?php

namespace Cxj\LookingGlassPkg;

use Illuminate\Support\ServiceProvider;

class LookingGlassPkgServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot(): void
    {
        // $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'cxj');
        // $this->loadViewsFrom(__DIR__.'/../resources/views', 'cxj');
        // $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        // $this->loadRoutesFrom(__DIR__.'/routes.php');

        // Publishing is only necessary when using the CLI.
        if ($this->app->runningInConsole()) {
            $this->bootForConsole();
        }
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/looking-glass-pkg.php', 'looking-glass-pkg');

        // Register the service the package provides.
        $this->app->singleton('looking-glass-pkg', function ($app) {
            return new LookingGlassPkg;
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['looking-glass-pkg'];
    }

    /**
     * Console-specific booting.
     *
     * @return void
     */
    protected function bootForConsole(): void
    {
        // Publishing the configuration file.
        $this->publishes([
            __DIR__.'/../config/looking-glass-pkg.php' => config_path('looking-glass-pkg.php'),
        ], 'looking-glass-pkg.config');

        // Publishing the views.
        /*$this->publishes([
            __DIR__.'/../resources/views' => base_path('resources/views/vendor/cxj'),
        ], 'looking-glass-pkg.views');*/

        // Publishing assets.
        /*$this->publishes([
            __DIR__.'/../resources/assets' => public_path('vendor/cxj'),
        ], 'looking-glass-pkg.views');*/

        // Publishing the translation files.
        /*$this->publishes([
            __DIR__.'/../resources/lang' => resource_path('lang/vendor/cxj'),
        ], 'looking-glass-pkg.views');*/

        // Registering package commands.
        // $this->commands([]);
    }
}
