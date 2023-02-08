<?php

namespace Dystcz\Process\Domain\Processes\Traits;

use Dystcz\Process\Domain\Processes\Models\Process;

trait HandlesProcessEvents
{
    /**
     * Callback which is called when the process is created.
     *
     * @return void
     */
    public function onCreated(Process $process): void
    {
    }

    /**
     * Callback which is called when the process is updated.
     *
     * @return void
     */
    public function onUpdated(Process $process): void
    {
    }

    /**
     * Callback which is called when the process is finished.
     *
     * @return void
     */
    public function onFinished(Process $process): void
    {
    }
}
