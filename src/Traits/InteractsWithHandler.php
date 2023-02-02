<?php

namespace Dystcz\Process\Traits;

use Dystcz\Process\Contracts\ProcessHandlerContract;

trait InteractsWithHandler
{
    /**
     * Initialise the handler class.
     *
     * @return ProcessHandlerContract
     */
    public function handler(): ProcessHandlerContract
    {
        return (new $this->handler_type)($this);
    }
}
