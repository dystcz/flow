<?php

declare(strict_types=1);

namespace Dystcz\Flow\Domain\Flows\Commands;

use Illuminate\Console\Concerns\CreatesMatchingTest;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Support\Facades\Config;

class MakeFlowHandlerCommand extends DomainGeneratorCommand
{
    use CreatesMatchingTest;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'make:flow-handler';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a flow handler';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Handler';

    /**
     * Get the default namespace for the class.
     *
     * @param  string  $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        $type = 'Handlers';

        if ($domain = $this->option('domain')) {
            return "{$rootNamespace}\\{$domain}\\{$type}";
        }

        if (Config::get('flow.handlers.default_namespace')) {
            return Config::get('flow.handlers.default_namespace');
        }

        return "{$rootNamespace}\\Flow\\{$type}";
    }

    /**
     * Get stub.
     *
     * @throws BindingResolutionException
     */
    protected function getStub(): string
    {
        return __DIR__.'/stubs/flow-handler.stub';
    }
}
