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
        $handler = $process->handler();

        $handler->onCreate($process);
    }

    /**
     * Handle the Process "updated" event.
     *
     * @param  Process  $process
     * @return void
     */
    public function updated(Process $process): void
    {
        $handler = $process->handler();

        $handler->onUpdate($process);

        if ($handler->isFinished()) {
            $process->fireModelEvent('finished', false);
        }
    }

    /**
     * Handle the Process "finished" event.
     *
     * @param  Process  $process
     * @return void
     */
    public function finished(Process $process): void
    {
        $handler = $process->handler();

        // If the process is not finished, do not continue
        if (!$handler->isFinished()) {
            return;
        }

        $handler->onFinished($process);

        // Check blocking processes (parents)
        // If any of them is not finished, do not continue
        // If all of them are finished, spawn next processes (children)
    }
}
