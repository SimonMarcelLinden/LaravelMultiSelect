<?php

namespace SimonMarcelLinden\LaravelMultiSelect;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use SimonMarcelLinden\LaravelMultiSelect\Console\Commands\PackageCommand;

class LaravelMultiSelectServiceProvider extends ServiceProvider {
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot(): void {
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'SimonMarcelLinden');
        Blade::component('SimonMarcelLinden::components.multiSelect', 'multiSelect');

        if ($this->app->runningInConsole()) {
            $this->bootForConsole();
            $this->commands([
                PackageCommand::class,
            ]);
        }
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register(): void {
        $this->mergeConfigFrom(__DIR__.'/../config/laravelmultiselect.php', 'laravelmultiselect');

        // Register the service the package provides.
        $this->app->singleton('laravelmultiselect', function ($app) {
            return new LaravelMultiSelect;
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides() {
        return ['laravelmultiselect'];
    }

    /**
     * Console-specific booting.
     *
     * @return void
     */
    protected function bootForConsole(): void {
        // Publishing the configuration file.
        $this->publishes([
            __DIR__.'/../config/laravelmultiselect.php' => config_path('laravelmultiselect.php'),
        ], 'laravelmultiselect.config');
    }
}
