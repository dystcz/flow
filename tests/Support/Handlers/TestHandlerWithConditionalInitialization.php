<?php

declare(strict_types=1);

namespace Dystcz\Flow\Tests\Support\Handlers;

use Dystcz\Flow\Domain\Flows\Contracts\HasFlow;
use Dystcz\Flow\Domain\Flows\Handlers\FlowHandler;
use Dystcz\Flow\Domain\Flows\Http\Requests\FlowRequest;

class TestHandlerWithConditionalInitialization extends FlowHandler
{
    public static string $name = 'Flow step with conditional initialization';

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
     * Determine if the step should be initialized.
     */
    public static function shouldInitialize(HasFlow $model): bool
    {
        return true;
    }
}
