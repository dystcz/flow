<?php

namespace Dystcz\Process\Handlers;

use Dystcz\Process\Contracts\Processable;
use Dystcz\Process\Contracts\ProcessHandlerContract;
use Dystcz\Process\Http\Requests\ProcessRequest;
use Dystcz\Process\Models\Process;
use Dystcz\Process\Traits\HandlesAuthorization;
use Dystcz\Process\Traits\HandlesFields;
use Dystcz\Process\Traits\HandlesValidation;

abstract class ProcessHandler implements ProcessHandlerContract
{
    use HandlesAuthorization;
    use HandlesValidation;
    use HandlesFields;

    public function __construct(public Process $process)
    {
    }

    /**
     * Handle the process.
     *
     * @return void
     */
    public function handle(ProcessRequest $request): void
    {
        $data = $this->setFieldValuesFromRequest($request);

        $this->saveFieldData($data);
    }

    /**
     * Return a fresh handler instance.
     *
     * @return static
     */
    protected static function newHandler()
    {
        return new static(new Process);
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
