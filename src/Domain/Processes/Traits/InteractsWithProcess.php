<?php

namespace Dystcz\Process\Domain\Processes\Traits;

use Dystcz\Process\Domain\Processes\Models\Process;

trait InteractsWithProcess
{
    /**
     * Get process.
     *
     * @return Process
     */
    public function process(): Process
    {
        return $this->process;
    }
}
