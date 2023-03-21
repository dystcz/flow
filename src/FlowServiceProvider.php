<?php

declare(strict_types=1);

namespace Dystcz\Flow;

use Dystcz\Flow\Domain\Flows\Commands\MakeFlowHandlerCommand;
use Dystcz\Flow\Domain\Flows\Flow;
use Dystcz\Flow\Domain\Flows\Models\Node;
use Dystcz\Flow\Domain\Flows\Models\Step;
use Dystcz\Flow\Domain\Flows\Models\Template;
use Dystcz\Flow\Domain\Flows\Observers\NodeObserver;
use Dystcz\Flow\Domain\Flows\Observers\StepObserver;
use Dystcz\Flow\Domain\Flows\Observers\TemplateObserver;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;

class FlowServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot(): void
    {
        // Observers
        Config::get('flow.steps.model')::observe(StepObserver::class);
        Config::get('flow.nodes.model')::observe(NodeObserver::class);
        Config::get('flow.templates.model')::observe(TemplateObserver::class);

        /*
         * Optional methods to load your package assets
         */
        // $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'flow');
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        $this->loadRoutesFrom(__DIR__.'/../routes/routes.php');

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/flow.php' => config_path('flow.php'),
            ], 'config');

            // Registering package commands.
            $this->commands([
                MakeFlowHandlerCommand::class,
            ]);
        }
    }

    /**
     * Register the application services.
     */
    public function register(): void
    {
        // Swap models for those defined in the configuration
        $this->app->bind(Step::class, Config::get('flow.steps.model'));
        $this->app->bind(Template::class, Config::get('flow.templates.model'));
        $this->app->bind(Node::class, Config::get('flow.nodes.model'));

        // Automatically apply the package configuration
        $this->mergeConfigFrom(__DIR__.'/../config/flow.php', 'flow');

        // Register the main class to use with the facade
        $this->app->singleton('flow', function () {
            return new Flow();
        });
    }
}
