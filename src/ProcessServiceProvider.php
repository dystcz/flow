<?php

namespace Dystcz\Process;

use Dystcz\Process\Domain\Processes\Commands\MakeProcessHandlerCommand;
use Dystcz\Process\Domain\Processes\Models\Process as ProcessModel;
use Dystcz\Process\Domain\Processes\Models\ProcessNode;
use Dystcz\Process\Domain\Processes\Models\ProcessTemplate;
use Dystcz\Process\Domain\Processes\Process;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;

class ProcessServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot(): void
    {
        // Observers
        Config::get('process.processes.model')::observe(Config::get('process.processes.observer'));
        Config::get('process.nodes.model')::observe(Config::get('process.nodes.observer'));
        Config::get('process.templates.model')::observe(Config::get('process.templates.observer'));

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
            $this->commands([
                MakeProcessHandlerCommand::class,
            ]);
        }
    }

    /**
     * Register the application services.
     */
    public function register(): void
    {
        // Swap models for those defined in the configuration
        $this->app->bind(ProcessModel::class, Config::get('process.processes.model'));
        $this->app->bind(ProcessTemplate::class, Config::get('process.templates.model'));
        $this->app->bind(ProcessNode::class, Config::get('process.nodes.model'));

        // Automatically apply the package configuration
        $this->mergeConfigFrom(__DIR__ . '/../config/process.php', 'process');

        // Register the main class to use with the facade
        $this->app->singleton('process', function () {
            return new Process();
        });
    }
}
