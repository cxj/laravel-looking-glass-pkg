<?php

namespace Cxj\LookingGlass;

use Cxj\LookingGlass\Console\Commands\RunHealthChecksCommand;
use Cxj\LookingGlass\View\Components\AppLayout;
use Illuminate\Foundation\Console\AboutCommand;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Spatie\Health\HealthServiceProvider;
use Spatie\WebhookClient\WebhookClientServiceProvider;

class LookingGlassServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     */
    public function boot(): void
    {
        echo 'BOOT '.__METHOD__.PHP_EOL; // debug

        // $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'cxj');

        Blade::component('app-layout', AppLayout::class);
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'cxj');
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        $this->loadRoutesFrom(__DIR__.'/routes.php');

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
        echo 'WTF '.__METHOD__.PHP_EOL; // debug

        $this->mergeConfigFrom(
            __DIR__.'/../config/looking-glass.php',
            'looking-glass'
        );

        // Register the service the package provides.
        $this->app->singleton('looking-glass', function ($app) {
            return new LookingGlassServiceProvider($app);
        });

        // FAWKING Laravel
        // This needs to be here to be sure Webhook service provider gets
        // loaded before the custom webhook route is registered by Laravel.
        $this->app->register(WebhookClientServiceProvider::class);

        $this->app->register(HealthServiceProvider::class); // testing?

        /*
         * Needed?
         * Create aliases for the dependency.
         */
        $loader = \Illuminate\Foundation\AliasLoader::getInstance();
//        $loader->alias('AuthorizationServer', 'LucaDegasperi\OAuth2Server\Facades\AuthorizationServerFacade');
//        $loader->alias('ResourceServer', 'LucaDegasperi\OAuth2Server\Facades\ResourceServerFacade');
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
        echo __METHOD__.' publishing config and command...'.PHP_EOL; // debug

        // Publishing the configuration file.
        $this->publishes([
            __DIR__.'/../config/looking-glass.php' => config_path(
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
