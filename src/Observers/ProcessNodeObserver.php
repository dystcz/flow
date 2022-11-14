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
    protected function created(ProcessNode $node): void
    {
        //
    }

    /**
     * Handle the ProcessNode "updated" event.
     *
     * @param  ProcessNode  $node
     * @return void
     */
    protected function updated(ProcessNode $node): void
    {
        //
    }

    /**
     * Handle the ProcessNode "deleted" event.
     *
     * @param  ProcessNode  $node
     * @return void
     */
    protected function deleted(ProcessNode $node): void
    {
        //
    }

    /**
     * Handle the ProcessNode "restored" event.
     *
     * @param  ProcessNode  $node
     * @return void
     */
    protected function restored(ProcessNode $node): void
    {
        //
    }

    /**
     * Handle the ProcessNode "forceDeleted" event.
     *
     * @param  ProcessNode  $node
     * @return void
     */
    protected function forceDeleted(ProcessNode $node): void
    {
        //
    }
}
