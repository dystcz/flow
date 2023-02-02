<?php

namespace Dystcz\Process\Traits;

use Dystcz\Process\Contracts\Processable;
use Dystcz\Process\Models\Process;

trait InteractsWithModel
{
    /**
     * Get model.
     *
     * @return Process
     */
    public function model(): Processable
    {
        return $this->process->model;
    }
}
