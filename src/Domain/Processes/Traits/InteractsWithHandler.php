<?php

namespace Dystcz\Process\Domain\Processes\Traits;

use Dystcz\Process\Domain\Processes\Contracts\ProcessHandlerContract;

trait InteractsWithHandler
{
    /**
     * Initialise the handler class.
     *
     * @return ProcessHandlerContract
     */
    public function handler(): ProcessHandlerContract
    {
        return new $this->handler_type($this);
    }
}
