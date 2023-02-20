<?php

namespace Dystcz\Flow\Tests\Support\Handlers;

use Dystcz\Flow\Domain\Flows\Handlers\FlowHandler;
use Dystcz\Flow\Domain\Flows\Http\Requests\FlowRequest;
use Dystcz\Flow\Domain\Flows\Models\Step;

class TestHandlerWithOnUpdatedEvent extends FlowHandler
{
    public static string $name = 'Flow step with on updated event';

    public static string $group = 'flow';

    /**
     * {@inheritDoc}
     */
    public function handle(FlowRequest $request): void
    {
        parent::handle($request);
    }

    /**
     * {@inheritDoc}
     */
    public function fields(): array
    {
        return [];
    }

    /**
     * Callback which is called when the step is updated.
     */
    public function onUpdated(Step $step): void
    {
    }
}
