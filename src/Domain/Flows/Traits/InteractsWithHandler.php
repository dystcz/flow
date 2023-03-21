<?php

declare(strict_types=1);

namespace Dystcz\Flow\Domain\Flows\Traits;

use Dystcz\Flow\Domain\Flows\Contracts\FlowHandlerContract;

trait InteractsWithHandler
{
    /**
     * Initialise the handler class.
     */
    public function handler(): FlowHandlerContract
    {
        return new $this->handler($this);
    }
}
