<?php

namespace Dystcz\Flow\Domain\Flows\Blueprints;

use Exception;
use Illuminate\Database\Eloquent\Model;

abstract class FlowBlueprint
{
    protected string $model = Model::class;

    protected string $templateName = 'Default template';

    /**
     * Flow steps.
     */
    public function steps(): array
    {
        return [];
    }

    /**
     * Check flow blueprint health.
     *
     * @throws Exception
     */
    protected function checkHealth(): void
    {
        if (false) {
            throw new Exception('Health check failed');
        }
    }
}
