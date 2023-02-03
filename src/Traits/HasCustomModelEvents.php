<?php

namespace Dystcz\Process\Traits;

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
