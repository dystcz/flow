<?php

namespace Dystcz\Flow\Domain\Flows\Blueprints;

use Exception;

class FlowBlueprint
{
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
