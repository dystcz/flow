<?php

declare(strict_types=1);

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
     * Finish flow step.
     */
    public function finish(): void;

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
     * Callback which is called when the step is creating.
     */
    public function onCreating(Step $step): void;

    /**
     * Callback which is called when the step is created.
     */
    public function onCreated(Step $step): void;

    /**
     * Callback which is called when the step is saving.
     */
    public function onSaving(Step $step): void;

    /**
     * Callback which is called when the step is saved.
     */
    public function onSaved(Step $step): void;

    /**
     * Callback which is called when the step is updating.
     */
    public function onUpdating(Step $step): void;

    /**
     * Callback which is called when the step is updated.
     */
    public function onUpdated(Step $step): void;

    /**
     * Callback which is called when the step is finishing.
     */
    public function onFinishing(Step $step): void;

    /**
     * Callback which is called when the step is finished.
     */
    public function onFinished(Step $step): void;

    /**
     * Get flow step name.
     */
    public static function name(): string;

    /**
     * Get flow step group.
     */
    public static function group(): string;

    /**
     * Get flow step key.
     */
    public static function key(): string;

    /**
     * Get flow step description.
     *
     * @return ?string
     */
    public static function description(): ?string;

    /**
     * Get flow meta attributes.
     */
    public static function meta(): array;
}
