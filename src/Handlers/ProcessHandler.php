<?php

namespace Dystcz\Process\Handlers;

use App\Notifications\ProcessNotification;
use Dystcz\Process\Collections\ProcessCollection;
use Dystcz\Process\Contracts\HandlerContract;
use Dystcz\Process\Http\Requests\ProcessRequest;
use Dystcz\Process\Models\Process;
use Dystcz\Process\Models\ProcessConfig;

abstract class ProcessHandler implements HandlerContract
{
    protected string $notificationClass = ProcessNotification::class;

    protected ProcessNotification $notification;

    protected ProcessConfig $config;

    public function __construct(protected Process $process)
    {
        $this->process->loadMissing([
            'config',
            'config.blockingProcesses',
        ]);

        $this->config = $this->process->config;

        $this->notification = new ($this->notificationClass)($this->process);
    }

    /**
     * Handle process save.
     *
     * @param ProcessRequest $request
     * @return void
     */
    public function handle(ProcessRequest $request): array
    {
        // Main method

        return [];
    }

    /**
     * Check that all blocking processes are finishedo.
     *
     * @return bool
     */
    public function initialisable(): bool
    {
        // If there are no unfinished blocking processes, return true.
        return $this->getUnfinishedBlockingProcesses()->isEmpty();
    }

    /**
     * Get all blocking processes.
     *
     * @return ProcessCollection
     */
    public function getBlockingProcesses(): ProcessCollection
    {
        $blocking = $this->process->config->blockingProcesses;

        // Get all processes in the tree
        // Filter out those, that are blocking

        return $blocking;
    }

    /**
     * Get all unfinished blocking processes.
     *
     * @return ProcessCollection
     */
    public function getUnfinishedBlockingProcesses(): ProcessCollection
    {
        return $this->getBlockingProcesses()->filter(
            fn ($process) => !$process->isFinished()
        );
    }

    /**
     * Get collection of prev processes.
     *
     * @return ProcessCollection<Process>
     */
    public function prevProcesses(): ProcessCollection
    {
        // TODO: Implement retrieval of previous processes from process config tree.
        return new ProcessCollection();
    }

    /**
     * Get collection of next processes.
     *
     * @return ProcessCollection<Process>
     */
    public function nextProcesses(): ProcessCollection
    {
        // TODO: Implement retrieval of next processes from process config tree.
        return new ProcessCollection();
    }

    /**
     * Handle the Process "created" event.
     *
     * @param  Process  $process
     * @return void
     */
    protected function created(Process $process): void
    {
        //
    }

    /**
     * Handle the Process "updated" event.
     *
     * @param  Process  $process
     * @return void
     */
    protected function updated(Process $process): void
    {
        //
    }

    /**
     * Handle the Process "closed" event.
     *
     * @param  Process  $process
     * @return void
     */
    protected function closed(Process $process): void
    {
        //
    }

    /**
     * Handle the Process "reopened" event.
     *
     * @param  Process  $process
     * @return void
     */
    protected function reopened(Process $process): void
    {
        //
    }

    /**
     * Handle the Process "finished" event.
     *
     * @param  Process  $process
     * @return void
     */
    protected function finished(Process $process): void
    {
        //
    }
}
