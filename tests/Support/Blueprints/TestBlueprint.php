<?php

declare(strict_types=1);

namespace Dystcz\Flow\Tests\Support\Blueprints;

use Dystcz\Flow\Domain\Flows\Blueprints\FlowBlueprint;
use Dystcz\Flow\Tests\Support\Models\TestModel;

class TestBlueprint extends FlowBlueprint
{
    protected string $model = TestModel::class;

    protected string $templateName = 'Test template';

    /**
     * Flow steps.
     */
    public function steps(): array
    {
        return [];
    }
}
