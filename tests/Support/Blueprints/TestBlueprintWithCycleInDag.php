<?php

namespace Dystcz\Flow\Tests\Support\Blueprints;

use Dystcz\Flow\Domain\Flows\Blueprints\FlowBlueprint;
use Dystcz\Flow\Tests\Support\Handlers\TestHandler;
use Dystcz\Flow\Tests\Support\Models\TestModel;

class TestBlueprintWithCycleInDag extends FlowBlueprint
{
    protected string $model = TestModel::class;

    protected string $templateName = 'Test template with cycle in dag';

    /**
     * Flow steps.
     */
    public function steps(): array
    {
        return [
            TestHandler::class => [
                TestHandler::class,
            ],
        ];
    }
}
