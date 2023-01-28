<?php

namespace Dystcz\Process\Observers;

use Dystcz\Process\Models\Process;

class ProcessObserver
{
    /**
     * Handle the Process "created" event.
     *
     * @param  Process  $process
     * @return void
     */
    public function created(Process $process): void
    {
        //
    }

    /**
     * Handle the Process "updated" event.
     *
     * @param  Process  $process
     * @return void
     */
    public function updated(Process $process): void
    {
        //
    }

    /**
     * Handle the Process "deleted" event.
     *
     * @param  Process  $process
     * @return void
     */
    public function deleted(Process $process): void
    {
        //
    }

    /**
     * Handle the Process "restored" event.
     *
     * @param  Process  $process
     * @return void
     */
    public function restored(Process $process): void
    {
        //
    }

    /**
     * Handle the Process "forceDeleted" event.
     *
     * @param  Process  $process
     * @return void
     */
    public function forceDeleted(Process $process): void
    {
        //
    }
}
