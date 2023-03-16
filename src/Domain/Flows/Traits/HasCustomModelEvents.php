<?php

namespace Dystcz\Flow\Domain\Flows\Traits;

use Closure;

trait HasCustomModelEvents
{
    /**
     * Fire finished event.
     */
    public function fireFinishingEvent(bool $halt = false): void
    {
        $this->fireModelEvent('finishing', $halt);
    }

    /**
     * Register a finishing model event with the dispatcher.
     *
     * @param  \Illuminate\Events\QueuedClosure|Closure|string|array  $callback
     * @return void
     */
    public static function finishing($callback)
    {
        static::registerModelEvent('finishing', $callback);
    }

    /**
     * Fire finished event.
     */
    public function fireFinishedEvent(bool $halt = false): void
    {
        $this->fireModelEvent('finished', $halt);
    }

    /**
     * Register a finished model event with the dispatcher.
     *
     * @param  \Illuminate\Events\QueuedClosure|Closure|string|array  $callback
     * @return void
     */
    public static function finished($callback)
    {
        static::registerModelEvent('finished', $callback);
    }
}
