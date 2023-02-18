<?php

namespace Dystcz\Flow\Domain\Flows\Contracts;

use Dystcz\Flow\Domain\Flows\Http\Requests\FlowRequest;
use Dystcz\Flow\Domain\Flows\Models\Step;

interface FlowHandlerContract
{
    /**
     * Handle the flow.
     */
    public function handle(FlowRequest $request): void;

    /**
     * Define step fields.
     */
    public function fields(): array;

    /**
     * Determine if the step is finished.
     */
    public function isComplete(): bool;

    /**
     * Get step model instance.
     */
    public function step(): Step;

    /**
     * Get model instance.
     */
    public function model(): HasFlow;

    /**
     * Callback which is called when the step is created.
     */
    public function onCreated(Step $step): void;

    /**
     * Callback which is called when the step is updated.
     */
    public function onUpdated(Step $step): void;

    /**
     * Callback which is called when the step is finished.
     */
    public function onFinished(Step $step): void;
}
