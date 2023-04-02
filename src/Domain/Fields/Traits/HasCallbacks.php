<?php

declare(strict_types=1);

namespace Dystcz\Flow\Domain\Fields\Traits;

use Closure;
use Dystcz\Flow\Domain\Fields\Contracts\FieldContract;
use Dystcz\Flow\Domain\Fields\Fields\Field;
use Dystcz\Flow\Domain\Flows\Contracts\FlowHandlerContract;
use Dystcz\Flow\Domain\Flows\Models\Step;
use InvalidArgumentException;

trait HasCallbacks
{
    public ?Closure $retrieveCallback = null;

    public ?Closure $saveCallback = null;

    public ?Closure $formatCallback = null;

    /**
     * Set save callback.
     *
     * @param  Closure(FieldContract, FlowHandlerContract): void
     */
    public function handleSave(Closure $saveCallback): Field
    {
        $this->saveCallback = $saveCallback;

        return $this;
    }

    /**
     * Set save to multiple steps callback.
     * Saves data to this step and other defined steps.
     *
     * @param  array<string>  $otherHandlers
     */
    public function handleSaveToMultipleSteps(array $targetHandlers): self
    {
        $this->handleSave(function (FieldContract $field, FlowHandlerContract $handler) use ($targetHandlers) {
            // Save field to this step data
            $field->handler()->save($field, $handler);

            foreach ($targetHandlers as $handlerClass) {
                if (! (new $handlerClass(new Step)) instanceof FlowHandlerContract) {
                    throw new InvalidArgumentException('All handlers must implement FlowHandlerContract.');
                }

                // Save field to project detail data
                $step = $handler->model()->getStepByKey($handlerClass::key());

                // Save field value
                $field->handler()->save($field, $step->handler());

                // Save step model
                $step->save();
            }
        });

        return $this;
    }

    /**
     * Set retrieve callback.
     *
     * @param  Closure(FieldContract, FlowHandlerContract): mixed
     */
    public function handleRetrieve(Closure $retrieveCallback): Field
    {
        $this->retrieveCallback = $retrieveCallback;

        return $this;
    }

    /**
     * Set retrieve from other step callback.
     */
    public function handleRetrieveFromOtherStep(string $targetHandler, ?string $fieldKey = null): Field
    {
        /** @var FieldContract $field */
        $field = $this;

        $this->handleRetrieve(function (
            FieldContract $field,
            FlowHandlerContract $fieldHandler,
        ) use ($targetHandler, $fieldKey) {
            return $fieldHandler->model()
                ->getStepByKey($targetHandler::key())
                ?->getFieldValue($fieldKey ?? $field->getKey());
        });

        $field->setConfigKey('retrieved_from_key', $targetHandler::key());
        $field->setConfigKey('retrieved_from_name', $targetHandler::name());

        return $field;
    }

    /**
     * Set retrieve from other step and save to other step callback.
     */
    public function retrieveAndSaveToOtherStep(string $targetHandler): self
    {
        $this->handleRetrieveFromOtherStep($targetHandler);
        $this->handleSaveToMultipleSteps([$targetHandler]);

        return $this;
    }

    /**
     * Set format callback.
     *
     * @param  Closure(FieldContract, FlowHandlerContract): mixed
     */
    public function handleFormat(Closure $formatCallback): Field
    {
        $this->formatCallback = $formatCallback;

        return $this;
    }
}
