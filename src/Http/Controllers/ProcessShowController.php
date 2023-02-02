<?php

namespace Dystcz\Process\Http\Controllers;

use Dystcz\Process\Handlers\ProcessHandler;
use Dystcz\Process\Http\Requests\ProcessRequest;
use Dystcz\Process\Http\Resources\ProcessResource;
use Dystcz\Process\Models\Process;
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
