<?php

namespace Dystcz\Process\Observers;

use Dystcz\Process\Models\Process;
use Dystcz\Process\Models\ProcessConfig;

class ProcessConfigObserver
{
    /**
     * Handle the ProcessConfig "created" event.
     *
     * @param  Process  $processConfig
     * @return void
     */
    protected function created(ProcessConfig $processConfig): void
    {
        //
    }

    /**
     * Handle the ProcessConfig "updated" event.
     *
     * @param  Process  $processConfig
     * @return void
     */
    protected function updated(ProcessConfig $processConfig): void
    {
        //
    }

    /**
     * Handle the ProcessConfig "deleted" event.
     *
     * @param  Process  $processConfig
     * @return void
     */
    protected function deleted(ProcessConfig $processConfig): void
    {
        //
    }

    /**
     * Handle the ProcessConfig "restored" event.
     *
     * @param  Process  $processConfig
     * @return void
     */
    protected function restored(ProcessConfig $processConfig): void
    {
        //
    }

    /**
     * Handle the ProcessConfig "forceDeleted" event.
     *
     * @param  Process  $processConfig
     * @return void
     */
    protected function forceDeleted(ProcessConfig $processConfig): void
    {
        //
    }
}
