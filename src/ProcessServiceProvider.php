<?php

namespace Dystcz\Process;

use Dystcz\Process\Handlers\ProcessHandler;
use Dystcz\Process\Models\Process;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;

class ProcessServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot(): void
    {
        /*
         * Optional methods to load your package assets
         */
        // $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'process');
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
        $this->loadRoutesFrom(__DIR__ . '/../routes/routes.php');

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/process.php' => config_path('process.php'),
            ], 'config');

            // Registering package commands.
            // $this->commands([]);

            // Observers
            Config::get('process.processes.model')::observe(Config::get('process.processes.observer'));
            Config::get('process.nodes.model')::observe(Config::get('process.nodes.observer'));
            Config::get('process.templates.model')::observe(Config::get('process.templates.observer'));
        }
    }

    /**
     * Register the application services.
     */
    public function register(): void
    {
        // Bind correct handler based on handler class stored in a specific process
        $this->app->bind(ProcessHandler::class, function ($app) {
            $process = Process::query()
                ->where('id', $app->request->process)
                ->first();

            return $app->make($process->handler, [$app->request, $process]);
        });

        // Automatically apply the package configuration
        $this->mergeConfigFrom(__DIR__ . '/../config/process.php', 'process');

        // Register the main class to use with the facade
        $this->app->singleton('process', function () {
            return new Process();
        });
    }
}
