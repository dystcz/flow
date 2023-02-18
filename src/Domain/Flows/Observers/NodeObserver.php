<?php

namespace Dystcz\Flow\Domain\Flows\Observers;

use Dystcz\Flow\Domain\Flows\Models\Node;

class NodeObserver
{
    /**
     * Handle the Node "created" event.
     */
    public function created(Node $node): void
    {
        //
    }

    /**
     * Handle the Node "updated" event.
     */
    public function updated(Node $node): void
    {
        //
    }

    /**
     * Handle the Node "deleted" event.
     */
    public function deleted(Node $node): void
    {
        //
    }

    /**
     * Handle the Node "restored" event.
     */
    public function restored(Node $node): void
    {
        //
    }

    /**
     * Handle the Node "forceDeleted" event.
     */
    public function forceDeleted(Node $node): void
    {
        //
    }
}
