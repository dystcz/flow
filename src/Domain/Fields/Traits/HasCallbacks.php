<?php

declare(strict_types=1);

namespace Dystcz\Flow\Domain\Fields\Traits;

use Closure;
use Dystcz\Flow\Domain\Fields\Contracts\FieldContract;
use Dystcz\Flow\Domain\Fields\Fields\Field;
use Dystcz\Flow\Domain\Flows\Contracts\FlowHandlerContract;

trait HasCallbacks
{
    public ?Closure $retrieveCallback = null;

    public ?Closure $saveCallback = null;

    public ?Closure $formatCallback = null;

    /**
     * Set save callback.
     */
    public function handleSave(Closure $saveCallback): Field
    {
        $this->saveCallback = $saveCallback;

        return $this;
    }

    /**
     * Set retrieve callback.
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

        $field->retrieveCallback = function (Field $field, FlowHandlerContract $fieldHandler) use ($targetHandler, $fieldKey) {
            return $fieldHandler->model()->getStepFieldValueByKey($targetHandler::key(), $fieldKey ?? $field->getKey());
        };

        $field->setConfigKey('retrieved_from_key', $targetHandler::key());
        $field->setConfigKey('retrieved_from_name', $targetHandler::name());

        return $field;
    }

    /**
     * Set format callback.
     */
    public function handleFormat(Closure $formatCallback): Field
    {
        $this->formatCallback = $formatCallback;

        return $this;
    }
}
