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
    public function process(): Process
    {
        return $this->process;
    }
}
