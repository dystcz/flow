<?php

namespace Dystcz\Process\Domain\Processes\Http\Controllers;

use Dystcz\Process\Domain\Base\Http\Controllers\Controller;
use Dystcz\Process\Domain\Processes\Http\Requests\ProcessRequest;
use Dystcz\Process\Domain\Processes\Models\Process;
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
