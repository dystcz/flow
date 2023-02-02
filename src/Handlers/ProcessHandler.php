<?php

namespace Dystcz\Process\Handlers;

use Dystcz\Process\Contracts\ProcessHandlerContract;
use Dystcz\Process\Http\Requests\ProcessRequest;
use Dystcz\Process\Models\Process;
use Dystcz\Process\Traits\HandlesAuthorization;
use Dystcz\Process\Traits\HandlesFields;
use Dystcz\Process\Traits\HandlesValidation;
use Dystcz\Process\Traits\InteractsWithModel;
use Dystcz\Process\Traits\InteractsWithProcess;

abstract class ProcessHandler implements ProcessHandlerContract
{
    use HandlesAuthorization;
    use HandlesFields;
    use HandlesValidation;
    use InteractsWithModel;
    use InteractsWithProcess;

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
        $this->saveFieldData($this->setFieldValuesFromRequest($request));
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
}
