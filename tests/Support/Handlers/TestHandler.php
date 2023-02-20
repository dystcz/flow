<?php

namespace Dystcz\Flow\Tests\Support\Handlers;

use Dystcz\Flow\Domain\Flows\Handlers\FlowHandler;
use Dystcz\Flow\Domain\Flows\Http\Requests\FlowRequest;

class TestHandler extends FlowHandler
{
    public static string $name = 'Flow step';

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
}
