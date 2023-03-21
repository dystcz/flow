<?php

declare(strict_types=1);

namespace Dystcz\Flow\Domain\Flows\Http\Controllers;

use Dystcz\Flow\Domain\Base\Http\Controllers\Controller;
use Dystcz\Flow\Domain\Flows\Handlers\FlowHandler;
use Dystcz\Flow\Domain\Flows\Http\Requests\FlowRequest;
use Dystcz\Flow\Domain\Flows\Models\Step;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class StepController extends Controller
{
    /**
     * Handle flow step.
     *
     * @throws ValidationException
     * @throws AuthorizationException
     */
    public function __invoke(FlowRequest $request, Step $step): mixed
    {
        /** @var FlowHandler $handler */
        $handler = $step->handler();

        $handler->step->load([
            'media',
            'model',
            'model.steps',
            'node',
            'node.children',
            'node.parents',
            'notifications',
            'users',
        ]);

        $handler::authorizeToHandleStep($request);
        $handler::validateStep($request);

        $handler->handle($request);

        return new JsonResponse('success', 200);
    }
}
