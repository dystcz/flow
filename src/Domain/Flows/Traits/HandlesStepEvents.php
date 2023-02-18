<?php

namespace Dystcz\Flow\Domain\Flows\Traits;

use Dystcz\Flow\Domain\Flows\Models\Step;

trait HandlesStepEvents
{
    /**
     * Callback which is called when the step is created.
     */
    public function onCreated(Step $step): void
    {
    }

    /**
     * Callback which is called when the step is updated.
     */
    public function onUpdated(Step $step): void
    {
    }

    /**
     * Callback which is called when the step is finished.
     */
    public function onFinished(Step $step): void
    {
    }
}
