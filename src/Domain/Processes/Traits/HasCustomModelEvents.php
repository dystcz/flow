<?php

namespace Dystcz\Process\Domain\Processes\Traits;

trait HasCustomModelEvents
{
    /**
     * Fire finished event.
     *
     * @return void
     */
    public function wasFinished(): void
    {
        $this->fireModelEvent('finished', false);
    }
}
