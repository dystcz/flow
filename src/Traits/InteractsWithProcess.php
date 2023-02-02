<?php

namespace Dystcz\Process\Traits;

use Dystcz\Process\Models\Process;

trait InteractsWithProcess
{
    /**
     * Get process.
     *
     * @return Process
     */
    public function getProcess(): Process
    {
        return $this->process;
    }
}
