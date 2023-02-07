<?php

namespace Dystcz\Process\Domain\Processes\Blueprints;

use Exception;

class ProcessBlueprint
{
    /**
     * Processes.
     *
     * @return array
     */
    public function processes(): array
    {
        return [];
    }

    /**
     * Check process blueprint health.
     *
     * @return void
     * @throws Exception
     */
    protected function checkHealth(): void
    {
        if (false) {
            throw new Exception('Health check failed');
        }
    }
}
