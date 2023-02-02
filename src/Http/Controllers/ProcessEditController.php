<?php

namespace Dystcz\Process\Http\Controllers;

use Dystcz\Process\Handlers\ProcessHandler;
use Dystcz\Process\Http\Requests\ProcessRequest;
use Dystcz\Process\Http\Resources\FieldResource;
use Dystcz\Process\Http\Resources\ProcessResource;
use Dystcz\Process\Models\Process;
use Illuminate\Http\JsonResponse;

class ProcessEditController extends Controller
{
    public function __invoke(ProcessRequest $request, Process $process): JsonResponse
    {
        /** @var ProcessHandler $handler */
        $handler = $process->handler();

        $handler::authorizeToEditProcess($request);

        $fields = $handler->setFieldValuesFromProcess($request);

        return new JsonResponse([
            'process' => new ProcessResource($process),
            'fields' => FieldResource::collection($fields),
        ], 200);
    }
}
