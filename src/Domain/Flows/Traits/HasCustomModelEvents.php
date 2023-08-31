<?php

declare(strict_types=1);

namespace Dystcz\Flow\Domain\Flows\Traits;

use Closure;
use Illuminate\Database\Eloquent\Model;

trait HasCustomModelEvents
{
    /**
     * Fire finished event.
     */
    public function fireFinishingEvent(bool $halt = false): void
    {
        /** @var Model $this */
        $this->fireModelEvent('finishing', $halt);
    }

    /**
     * Register a finishing model event with the dispatcher.
     *
     * @param  \Illuminate\Events\QueuedClosure|Closure|string|array  $callback
     */
    public static function finishing($callback): void
    {
        static::registerModelEvent('finishing', $callback);
    }

    /**
     * Fire finishing event.
     */
    public function fireFinishedEvent(bool $halt = false): void
    {
        /** @var Model $this */
        $this->fireModelEvent('finished', $halt);
    }

    /**
     * Register a finished model event with the dispatcher.
     *
     * @param  \Illuminate\Events\QueuedClosure|Closure|string|array  $callback
     */
    public static function finished($callback): void
    {
        static::registerModelEvent('finished', $callback);
    }

    /**
     * Fire skipping event.
     */
    public function fireSkippingEvent(bool $halt = false): void
    {
        /** @var Model $this */
        $this->fireModelEvent('skipping', $halt);
    }

    /**
     * Register a skipping model event with the dispatcher.
     *
     * @param  \Illuminate\Events\QueuedClosure|Closure|string|array  $callback
     */
    public static function skipping($callback): void
    {
        static::registerModelEvent('skipping', $callback);
    }

    /**
     * Fire skipped event.
     */
    public function fireSkippedEvent(bool $halt = false): void
    {
        /** @var Model $this */
        $this->fireModelEvent('skipped', $halt);
    }

    /**
     * Register a skipped model event with the dispatcher.
     *
     * @param  \Illuminate\Events\QueuedClosure|Closure|string|array  $callback
     */
    public static function skipped($callback): void
    {
        static::registerModelEvent('skipped', $callback);
    }
}
