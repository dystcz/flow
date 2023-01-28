<?php

namespace Dystcz\Process\Observers;

use Dystcz\Process\Models\ProcessNode;

class ProcessNodeObserver
{
    /**
     * Handle the ProcessNode "created" event.
     *
     * @param  ProcessNode  $node
     * @return void
     */
    public function created(ProcessNode $node): void
    {
        //
    }

    /**
     * Handle the ProcessNode "updated" event.
     *
     * @param  ProcessNode  $node
     * @return void
     */
    public function updated(ProcessNode $node): void
    {
        //
    }

    /**
     * Handle the ProcessNode "deleted" event.
     *
     * @param  ProcessNode  $node
     * @return void
     */
    public function deleted(ProcessNode $node): void
    {
        //
    }

    /**
     * Handle the ProcessNode "restored" event.
     *
     * @param  ProcessNode  $node
     * @return void
     */
    public function restored(ProcessNode $node): void
    {
        //
    }

    /**
     * Handle the ProcessNode "forceDeleted" event.
     *
     * @param  ProcessNode  $node
     * @return void
     */
    public function forceDeleted(ProcessNode $node): void
    {
        //
    }
}
