<?php

namespace Dystcz\Flow\Domain\Flows\Traits;

use Dystcz\Flow\Domain\Flows\Models\Step;

trait HandlesStepEvents
{
    /**
     * Callback which is called when the step is creating.
     */
    public function onCreating(Step $step): void
    {
    }

    /**
     * Callback which is called when the step is created.
     */
    public function onCreated(Step $step): void
    {
    }

    /**
     * Callback which is called when the step is saving.
     */
    public function onSaving(Step $step): void
    {
    }

    /**
     * Callback which is called when the step is saved.
     */
    public function onSaved(Step $step): void
    {
    }

    /**
     * Callback which is called when the step is updating.
     */
    public function onUpdating(Step $step): void
    {
    }

    /**
     * Callback which is called when the step is updated.
     */
    public function onUpdated(Step $step): void
    {
    }

    /**
     * Callback which is called when the step is finishing.
     */
    public function onFinishing(Step $step): void
    {
    }

    /**
     * Callback which is called when the step is finished.
     */
    public function onFinished(Step $step): void
    {
    }
}
