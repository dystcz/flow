<?php

declare(strict_types=1);

namespace Dystcz\Flow\Domain\Fields\Contracts;

use Closure;

interface FieldWithCallbacksContract
{
    /**
     * Set save callback.
     *
     * @param  Closure(FieldContract, FlowHandlerContract): void
     */
    public function handleSave(Closure $saveCallback): FieldContract;

    /**
     * Set save to multiple steps callback.
     * Saves data to this step and other defined steps.
     *
     * @param  array<string>  $otherHandlers
     */
    public function handleSaveToMultipleSteps(array $targetHandlers): FieldContract;

    /**
     * Set retrieve callback.
     *
     * @param  Closure(FieldContract, FlowHandlerContract): mixed
     */
    public function handleRetrieve(Closure $retrieveCallback): FieldContract;

    /**
     * Set retrieve from other step callback.
     */
    public function handleRetrieveFromOtherStep(string $targetHandler, ?string $fieldKey = null): FieldContract;

    /**
     * Set retrieve from other step and save to other step callback.
     */
    public function retrieveAndSaveToOtherStep(string $targetHandler): FieldContract;

    /**
     * Set format callback.
     *
     * @param  Closure(FieldContract, FlowHandlerContract): mixed
     */
    public function handleFormat(Closure $formatCallback): FieldContract;
}
