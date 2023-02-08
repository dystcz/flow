<?php

namespace Dystcz\Process\Domain\Processes\Http\Controllers;

use Dystcz\Process\Domain\Base\Http\Controllers\Controller;
use Dystcz\Process\Domain\Processes\Handlers\ProcessHandler;
use Dystcz\Process\Domain\Processes\Http\Requests\ProcessRequest;
use Dystcz\Process\Domain\Processes\Http\Resources\ProcessResource;
use Dystcz\Process\Domain\Processes\Models\Process;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;

class ProcessShowController extends Controller
{
    /**
     * Show process.
     *
     * @param ProcessRequest $request
     * @param Process $process
     * @return mixed
     * @throws AuthorizationException
     */
    public function __invoke(ProcessRequest $request, Process $process)
    {
        /** @var ProcessHandler $handler */
        $handler = $process->handler();

        $handler->authorizeToViewProcess($request);

        $handler->process->load([
            'model',
            'users',
        ]);

        return new JsonResponse([
            'process' => new ProcessResource($process),
        ], 200);
    }
}
