<?php

namespace Dystcz\Process\Domain\Processes\Observers;

use Dystcz\Process\Domain\Processes\Actions\InitializeNextProcesses;
use Dystcz\Process\Domain\Processes\Models\Process;

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

        if ($handler->isComplete()) {
            $process->wasFinished();
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
        if (!$handler->isComplete() || $process->isFinished()) {
            return;
        }

        $handler->onFinished($process);

        (new InitializeNextProcesses($process))->handle();

        $process->update(['finished' => true]);

        // Check next processes
        // Check their parents, if they are finished, spawn next processes
        // One of the parents if self
    }
}
