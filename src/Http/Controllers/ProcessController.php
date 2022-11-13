<?php

namespace Dystcz\Process\Http\Controllers;

use Dystcz\Process\Http\Requests\ProcessRequest;
use Dystcz\Process\Http\Resources\ProcessResource;
use Dystcz\Process\Models\Process;

class ProcessController extends Controller
{
    /**
     * Handle process update.
     *
     * @param ProcessRequest $request
     * @param Process $process
     * @return ProcessResource
     */
    public function __invoke(ProcessRequest $request, Process $process): ProcessResource
    {
        $process->handler()->handle($request);

        return new ProcessResource($process);
    }
}
