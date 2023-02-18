<?php

namespace Dystcz\Flow\Domain\Flows\Traits;

use Dystcz\Flow\Domain\Flows\Contracts\HasFlow;

trait InteractsWithModel
{
    /**
     * Get model.
     *
     * @return HasFlow
     */
    public function model(): HasFlow
    {
        return $this->flow->model;
    }
}
