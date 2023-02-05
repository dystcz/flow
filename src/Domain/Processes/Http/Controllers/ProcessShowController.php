<?php

namespace Dystcz\Process\Domain\Processes\Http\Controllers;

use Dystcz\Process\Domain\Base\Http\Controllers\Controller;
use Dystcz\Process\Domain\Processes\Http\Requests\ProcessRequest;
use Dystcz\Process\Domain\Processes\Http\Resources\ProcessResource;
use Dystcz\Process\Domain\Processes\Models\Process;
use Illuminate\Http\JsonResponse;

class ProcessShowController extends Controller
{
    public function __invoke(ProcessRequest $request, Process $process): JsonResponse
    {
        /** @var ProcessHandler $handler */
        $handler = $process->handler();

        $handler->authorizeToViewProcess($request);

        return new JsonResponse([
            'process' => new ProcessResource($process),
        ], 200);
    }
}
