<?php

namespace autoengine\crudpack;

use Illuminate\Support\ServiceProvider;

class CrudpackServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        // $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'autoengine');
        // $this->loadViewsFrom(__DIR__.'/../resources/views', 'autoengine');
        // $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        // $this->loadRoutesFrom(__DIR__.'/routes.php');
        include __DIR__.'/routes/Routes.php';

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
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/crudpack.php', 'crudpack');

        // Register the service the package provides.
        $this->app->singleton('crudpack', function ($app) {
            return new crudpack;
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['crudpack'];
    }
    
    /**
     * Console-specific booting.
     *
     * @return void
     */
    protected function bootForConsole()
    {
        // Publishing the configuration file.
        $this->publishes([
            __DIR__.'/../config/crudpack.php' => config_path('crudpack.php'),
        ], 'crudpack.config');

        // Publishing the views.
        /*$this->publishes([
            __DIR__.'/../resources/views' => base_path('resources/views/vendor/autoengine'),
        ], 'crudpack.views');*/

        // Publishing assets.
        /*$this->publishes([
            __DIR__.'/../resources/assets' => public_path('vendor/autoengine'),
        ], 'crudpack.views');*/

        // Publishing the translation files.
        /*$this->publishes([
            __DIR__.'/../resources/lang' => resource_path('lang/vendor/autoengine'),
        ], 'crudpack.views');*/

        // Registering package commands.
        // $this->commands([]);
    }
}
