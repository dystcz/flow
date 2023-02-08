<?php

namespace Dystcz\Process\Domain\Processes\Observers;

use Carbon\Carbon;
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

        $handler->onCreated($process);
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

        $handler->onUpdated($process);

        if ($handler->isComplete() && !$process->isFinished()) {
            $process->fireFinishedEvent();
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

        $handler->onFinished($process);

        (new InitializeNextProcesses($process))->handle();

        $process->update(['finished_at' => Carbon::now()]);
    }
}
