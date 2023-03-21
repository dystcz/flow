<?php

declare(strict_types=1);

namespace Dystcz\Flow\Domain\Flows\Traits;

use Dystcz\Flow\Domain\Flows\Contracts\HasFlow;

trait InteractsWithModel
{
    /**
     * Get model.
     */
    public function model(): HasFlow
    {
        return $this->step->model;
    }
}
