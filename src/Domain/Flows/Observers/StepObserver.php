<?php

declare(strict_types=1);

namespace Dystcz\Flow\Domain\Flows\Observers;

use Carbon\Carbon;
use Dystcz\Flow\Domain\Flows\Contracts\HoldsUntilFinished;
use Dystcz\Flow\Domain\Flows\Enums\StepStatus;
use Dystcz\Flow\Domain\Flows\Models\Step;

class StepObserver
{
    /**
     * Handle the Step "creating" event.
     */
    public function creating(Step $step): void
    {
        $handler = $step->handler();

        $handler->onCreating($step);
    }

    /**
     * Handle the Step "created" event.
     */
    public function created(Step $step): void
    {
        // TODO: Extract syncing users to a new action
        $step->load([
            'node',
            'node.users',
        ]);

        // Sync node users to step users
        $step->users()->sync($step->node->users->pluck('id')->toArray());

        $step->load([
            'users',
        ]);

        $handler = $step->handler();

        $handler->onCreated($step);
    }

    /**
     * Handle the Step "saving" event.
     */
    public function saving(Step $step): void
    {
        $handler = $step->handler();

        // Ensures that updated model event is fired and
        // gives us the benefit of knowing when it was last saved.
        $step->setAttribute('saved_at', Carbon::now());

        // If step holds until finished and is not finished and not on hold, set it to hold.
        if ($handler instanceof HoldsUntilFinished && ! $step->isFinished() && ! $step->hasStatus(StepStatus::HOLD)) {
            $step->setStatus(StepStatus::HOLD);
        }

        $handler->onSaving($step);
    }

    /**
     * Handle the Step "saved" event.
     */
    public function saved(Step $step): void
    {
        $handler = $step->handler();

        $handler->onSaved($step);
    }

    /**
     * Handle the Step "updating" event.
     */
    public function updating(Step $step): void
    {
        $handler = $step->handler();

        $handler->onUpdating($step);
    }

    /**
     * Handle the Step "updated" event.
     */
    public function updated(Step $step): void
    {
        $handler = $step->handler();

        $handler->onUpdated($step);
    }

    /**
     * Handle the Step "updating" event.
     */
    public function finishing(Step $step): void
    {
        $handler = $step->handler();

        $handler->onFinishing($step);
    }

    /**
     * Handle the Step "finished" event.
     */
    public function finished(Step $step): void
    {
        $handler = $step->handler();

        $handler->onFinished($step);
    }
}
