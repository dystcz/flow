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
        $handler = $this->prepareHander($request, $process);

        return new JsonResponse([
            'process' => new ProcessResource($process),
        ], 200);
    }

    /**
     * @param ProcessRequest $request
     * @param Process $process
     * @return ProcessHandler
     * @throws AuthorizationException
     */
    protected function prepareHander(ProcessRequest $request, Process $process): ProcessHandler
    {
        /** @var ProcessHandler $handler */
        $handler = $process->handler();

        $handler->authorizeToViewProcess($request);

        return $handler;
    }
}
