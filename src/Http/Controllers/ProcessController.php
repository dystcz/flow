<?php

namespace Dystcz\Process\Http\Controllers;

use Dystcz\Process\Handlers\ProcessHandler;
use Dystcz\Process\Http\Requests\ProcessRequest;
use Dystcz\Process\Models\Process;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class ProcessController extends Controller
{
    /**
     * Handle process.
     *
     * @param ProcessRequest $request
     * @return JsonResponse
     * @throws ValidationException
     * @throws AuthorizationException
     */
    public function __invoke(ProcessRequest $request, Process $process): JsonResponse
    {
        /** @var ProcessHandler $handler */
        $handler = $process->handler();

        $handler::authorizeToHandleProcess($request);
        $handler::validateProcess($request);

        $handler->handle($request);

        // Dispatch process handled event

        return new JsonResponse('success', 200);
    }
}
