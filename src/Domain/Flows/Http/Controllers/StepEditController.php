<?php

namespace Dystcz\Flow\Domain\Flows\Http\Controllers;

use Dystcz\Flow\Domain\Base\Http\Controllers\Controller;
use Dystcz\Flow\Domain\Fields\Http\Resources\FieldResource;
use Dystcz\Flow\Domain\Flows\Handlers\FlowHandler;
use Dystcz\Flow\Domain\Flows\Http\Requests\FlowRequest;
use Dystcz\Flow\Domain\Flows\Http\Resources\StepResource;
use Dystcz\Flow\Domain\Flows\Models\Step;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

class StepEditController extends Controller
{
    /**
     * Edit flow step.
     *
     * @return mixed
     *
     * @throws BadRequestException
     */
    public function __invoke(FlowRequest $request, Step $step)
    {
        /** @var FlowHandler $handler */
        $handler = $step->handler();

        $handler::authorizeToEditStep($request);

        $handler->step->load([
            'model',
            'users',
        ]);

        return new JsonResponse([
            'step' => new StepResource($step),
            'fields' => FieldResource::collection($handler->hydrateFieldsFromStep()),
        ], 200);
    }
}
