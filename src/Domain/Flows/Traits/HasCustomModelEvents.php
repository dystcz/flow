<?php

namespace Dystcz\Flow\Domain\Flows\Traits;

use Closure;

trait HasCustomModelEvents
{
    /**
     * Fire finished event.
     *
     * @return void
     */
    public function fireFinishedEvent(): void
    {
        $this->fireModelEvent('finished');
    }

    /**
     * Register a finished model event with the dispatcher.
     *
     * @param \Illuminate\Events\QueuedClosure|Closure|string|array $callback
     * @return void
     */
    public static function finished($callback)
    {
        static::registerModelEvent('finished', $callback);
    }
}
