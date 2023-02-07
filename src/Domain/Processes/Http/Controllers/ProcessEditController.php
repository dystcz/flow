<?php

namespace Dystcz\Process\Domain\Processes\Http\Controllers;

use Dystcz\Process\Domain\Base\Http\Controllers\Controller;
use Dystcz\Process\Domain\Fields\Http\Resources\FieldResource;
use Dystcz\Process\Domain\Processes\Handlers\ProcessHandler;
use Dystcz\Process\Domain\Processes\Http\Requests\ProcessRequest;
use Dystcz\Process\Domain\Processes\Http\Resources\ProcessResource;
use Dystcz\Process\Domain\Processes\Models\Process;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

class ProcessEditController extends Controller
{
    /**
     * Edit process.
     *
     * @param ProcessRequest $request
     * @param Process $process
     * @return mixed
     * @throws BadRequestException
     */
    public function __invoke(ProcessRequest $request, Process $process)
    {
        $handler = $this->prepareHander($request, $process);

        return new JsonResponse([
            'process' => new ProcessResource($process),
            'fields' => FieldResource::collection($handler->hydrateFieldsFromProcess()),
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

        $handler::authorizeToEditProcess($request);

        return $handler;
    }
}
