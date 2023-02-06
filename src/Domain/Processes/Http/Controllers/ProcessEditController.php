<?php

namespace Dystcz\Process\Domain\Processes\Http\Controllers;

use Dystcz\Process\Domain\Base\Http\Controllers\Controller;
use Dystcz\Process\Domain\Fields\Http\Resources\FieldResource;
use Dystcz\Process\Domain\Processes\Http\Requests\ProcessRequest;
use Dystcz\Process\Domain\Processes\Http\Resources\ProcessResource;
use Dystcz\Process\Domain\Processes\Models\Process;
use Illuminate\Http\JsonResponse;

class ProcessEditController extends Controller
{
    public function __invoke(ProcessRequest $request, Process $process): JsonResponse
    {
        /** @var ProcessHandler $handler */
        $handler = $process->handler();

        $handler::authorizeToEditProcess($request);

        return new JsonResponse([
            'process' => new ProcessResource($process),
            'fields' => FieldResource::collection($handler->hydrateFieldsFromProcess()),
        ], 200);
    }
}
