<?php

declare(strict_types=1);

namespace Dystcz\Flow\Domain\Fields\Traits;

use Closure;
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
        $this->retrieveCallback = function (Field $field, FlowHandlerContract $fieldHandler) use ($targetHandler, $fieldKey) {
            return $fieldHandler->model()->getStepFieldValue($targetHandler::key(), $fieldKey ?? $field->getKey());
        };

        return $this;
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
