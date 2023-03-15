<?php

namespace Dystcz\Flow\Domain\Flows\Observers;

use Carbon\Carbon;
use Dystcz\Flow\Domain\Flows\Actions\InitializeNextSteps;
use Dystcz\Flow\Domain\Flows\Enums\StepStatus;
use Dystcz\Flow\Domain\Flows\Models\Step;

class StepObserver
{
    /**
     * Handle the Step "created" event.
     */
    public function created(Step $step): void
    {
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
     * Handle the Step "updated" event.
     */
    public function updated(Step $step): void
    {
        $handler = $step->handler();

        $handler->onUpdated($step);

        $step->load([
            'users',
        ]);

        if ($handler->isComplete() && ! $step->isFinished()) {
            $step->fireFinishedEvent();
        }
    }

    /**
     * Handle the Step "finished" event.
     */
    public function finished(Step $step): void
    {
        $handler = $step->handler();

        $handler->onFinished($step);

        $step->update([
            'finished_at' => Carbon::now(),
            'status' => StepStatus::FINISHED,
        ]);

        $step->load([
            'model',
            'model.steps',
        ]);

        (new InitializeNextSteps($step))->handle();
    }
}
