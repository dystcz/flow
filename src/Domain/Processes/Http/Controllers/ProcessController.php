<?php

namespace Dystcz\Process\Domain\Processes\Http\Controllers;

use Dystcz\Process\Domain\Base\Http\Controllers\Controller;
use Dystcz\Process\Domain\Processes\Handlers\ProcessHandler;
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
     * @return mixed
     * @throws ValidationException
     * @throws AuthorizationException
     */
    public function __invoke(ProcessRequest $request, Process $process): mixed
    {
        /** @var ProcessHandler $handler */
        $handler = $process->handler();

        $handler->process->load([
            'model',
            'users',
        ]);

        $handler::authorizeToHandleProcess($request);
        $handler::validateProcess($request);

        $handler->handle($request);

        return new JsonResponse('success', 200);
    }
}
