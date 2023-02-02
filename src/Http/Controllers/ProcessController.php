<?php

namespace Dystcz\Process\Http\Controllers;

use Dystcz\Process\Handlers\ProcessHandler;
use Dystcz\Process\Http\Requests\ProcessRequest;
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
    public function __invoke(ProcessRequest $request): JsonResponse
    {
        /** @var ProcessHandler $handler */
        $handler = $request->getHandler();

        $handler::validateProcess($request);
        $handler::authorizeToHandleProcess($request);

        $handler->handle();

        // Dispatch process handled event

        return new JsonResponse('success', 200);
    }
}
