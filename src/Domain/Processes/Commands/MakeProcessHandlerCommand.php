<?php

namespace Dystcz\Process\Domain\Processes\Commands;

use Illuminate\Console\Command;
use Illuminate\Console\Concerns\CreatesMatchingTest;
use Illuminate\Contracts\Container\BindingResolutionException;

class MakeProcessHandlerCommand extends DomainGeneratorCommand
{
    use CreatesMatchingTest;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'make:process-handler';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a process handler';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'ProcessHandler';

    /**
     * Get stub.
     *
     * @return string
     * @throws BindingResolutionException
     */
    protected function getStub(): string
    {
        return __DIR__ . '/stubs/process-handler.stub';
    }
}
