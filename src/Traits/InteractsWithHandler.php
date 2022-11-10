<?php

namespace Dystcz\Process\Traits;

use Dystcz\Process\Contracts\HandlerContract;

trait InteractsWithHandler
{
    /**
     * Initialise the handler class.
     *
     * @return HandlerContract
     */
    public function handler(): HandlerContract
    {
        return new $this->handler($this);
    }
}
