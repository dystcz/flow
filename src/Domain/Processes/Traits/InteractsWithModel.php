<?php

namespace Dystcz\Process\Domain\Processes\Traits;

use Dystcz\Process\Domain\Processes\Contracts\Processable;

trait InteractsWithModel
{
    /**
     * Get model.
     *
     * @return Processable
     */
    public function model(): Processable
    {
        return $this->process->model;
    }
}
