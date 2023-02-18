<?php

namespace Dystcz\Flow\Domain\Flows\Http\Controllers;

use Dystcz\Flow\Domain\Base\Http\Controllers\Controller;
use Dystcz\Flow\Domain\Flows\Handlers\FlowHandler;
use Dystcz\Flow\Domain\Flows\Http\Requests\FlowRequest;
use Dystcz\Flow\Domain\Flows\Http\Resources\StepResource;
use Dystcz\Flow\Domain\Flows\Models\Step;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;

class StepShowController extends Controller
{
    /**
     * Show flow step.
     *
     * @return mixed
     *
     * @throws AuthorizationException
     */
    public function __invoke(FlowRequest $request, Step $step)
    {
        /** @var FlowHandler $handler */
        $handler = $step->handler();

        $handler->authorizeToViewStep($request);

        $handler->step->load([
            'model',
            'users',
        ]);

        return new JsonResponse([
            'step' => new StepResource($step),
        ], 200);
    }
}
