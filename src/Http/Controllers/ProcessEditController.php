<?php

namespace Dystcz\Process\Http\Controllers;

use Dystcz\Process\Handlers\ProcessHandler;
use Dystcz\Process\Http\Requests\ProcessRequest;
use Dystcz\Process\Http\Resources\FieldResource;
use Dystcz\Process\Http\Resources\ProcessResource;
use Illuminate\Http\JsonResponse;

class ProcessEditController extends Controller
{
    public function __invoke(ProcessRequest $request): JsonResponse
    {
        /** @var ProcessHandler $handler */
        $handler = $request->getHandler();

        $handler::authorizeToEditProcess($request);

        $process = $handler->getProcess();

        return new JsonResponse([
            'process' => new ProcessResource($process),
            'fields' => FieldResource::collection($handler->fields()),
        ], 200);
    }
}
