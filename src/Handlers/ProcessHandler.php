<?php

namespace Dystcz\Process\Handlers;

use Dystcz\Process\Contracts\Processable;
use Dystcz\Process\Contracts\ProcessHandlerContract;
use Dystcz\Process\Models\Process;
use Dystcz\Process\Traits\HandlesAuthorization;
use Dystcz\Process\Traits\HandlesValidation;

abstract class ProcessHandler implements ProcessHandlerContract
{
    use HandlesAuthorization;
    use HandlesValidation;

    public function __construct(public Process $process)
    {
    }

    /**
     * Handle the process.
     *
     * @return void
     */
    public function handle(): void
    {
    }

    /**
     * Define process field.
     *
     * @return array
     */
    public function fields(): array
    {
        return [];
    }

    /**
     * Get process.
     *
     * @return Process
     */
    public function getProcess(): Process
    {
        return $this->process;
    }

    /**
     * Get model.
     *
     * @return Process
     */
    public function getModel(): Processable
    {
        return $this->process->model;
    }
}
