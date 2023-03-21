<?php

declare(strict_types=1);

namespace Dystcz\Flow\Domain\Flows\Traits;

use Dystcz\Flow\Domain\Flows\Models\Step;

trait InteractsWithFlowStep
{
    /**
     * Get step.
     */
    public function step(): Step
    {
        return $this->step;
    }
}
