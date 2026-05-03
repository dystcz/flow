<?php

declare(strict_types=1);

namespace Dystcz\Flow\Domain\Flows\Traits;

use Closure;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Events\QueuedClosure;

trait HasCustomModelEvents
{
    /**
     * Register a finishing model event with the dispatcher.
     *
     * @param  QueuedClosure|Closure|string|array  $callback
     */
    public static function finishing($callback): void
    {
        static::registerModelEvent('finishing', $callback);
    }

    /**
     * Register a finished model event with the dispatcher.
     *
     * @param  QueuedClosure|Closure|string|array  $callback
     */
    public static function finished($callback): void
    {
        static::registerModelEvent('finished', $callback);
    }

    /**
     * Register a skipping model event with the dispatcher.
     *
     * @param  QueuedClosure|Closure|string|array  $callback
     */
    public static function skipping($callback): void
    {
        static::registerModelEvent('skipping', $callback);
    }

    /**
     * Register a skipped model event with the dispatcher.
     *
     * @param  QueuedClosure|Closure|string|array  $callback
     */
    public static function skipped($callback): void
    {
        static::registerModelEvent('skipped', $callback);
    }

    /**
     * Fire finished event.
     */
    public function fireFinishingEvent(bool $halt = false): void
    {
        /** @var Model $this */
        $this->fireModelEvent('finishing', $halt);
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
     * Fire skipping event.
     */
    public function fireSkippingEvent(bool $halt = false): void
    {
        /** @var Model $this */
        $this->fireModelEvent('skipping', $halt);
    }

    /**
     * Fire skipped event.
     */
    public function fireSkippedEvent(bool $halt = false): void
    {
        /** @var Model $this */
        $this->fireModelEvent('skipped', $halt);
    }
}
