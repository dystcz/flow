<?php

namespace Dystcz\Process\Observers;

use Dystcz\Process\Models\ProcessTemplate;

class ProcessTemplateObserver
{
    /**
     * Handle the ProcessTemplate "created" event.
     *
     * @param  ProcessTemplate  $template
     * @return void
     */
    public function created(ProcessTemplate $template): void
    {
        //
    }

    /**
     * Handle the ProcessTemplate "updated" event.
     *
     * @param  ProcessTemplate  $template
     * @return void
     */
    public function updated(ProcessTemplate $template): void
    {
        //
    }

    /**
     * Handle the ProcessTemplate "deleted" event.
     *
     * @param  ProcessTemplate  $template
     * @return void
     */
    public function deleted(ProcessTemplate $template): void
    {
        //
    }

    /**
     * Handle the ProcessTemplate "restored" event.
     *
     * @param  ProcessTemplate  $template
     * @return void
     */
    public function restored(ProcessTemplate $template): void
    {
        //
    }

    /**
     * Handle the ProcessTemplate "forceDeleted" event.
     *
     * @param  ProcessTemplate  $template
     * @return void
     */
    public function forceDeleted(ProcessTemplate $template): void
    {
        //
    }
}
