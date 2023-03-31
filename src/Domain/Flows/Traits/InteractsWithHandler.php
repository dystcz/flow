<?php

declare(strict_types=1);

namespace Dystcz\Flow\Domain\Flows\Traits;

use Dystcz\Flow\Domain\Fields\Contracts\FieldContract;
use Dystcz\Flow\Domain\Flows\Contracts\FlowHandlerContract;
use Illuminate\Support\Arr;

trait InteractsWithHandler
{
    /**
     * Initialise the handler class.
     */
    public function handler(): FlowHandlerContract
    {
        return new $this->handler($this);
    }

    /**
     * Get step field by step key and field key.
     */
    public function getFields(): array
    {
        return $this->handler()->fields();
    }

    /**
     * Get step field by field key.
     */
    public function getFieldByKey(string $fieldKey): ?FieldContract
    {
        /** @var FieldContract|null $field */
        return Arr::first($this->getFields(), fn (FieldContract $field) => $field->getKey() === $fieldKey);
    }

    /**
     * Get step field value by field key.
     */
    public function getFieldValue(string $fieldKey): mixed
    {
        return $this->getFieldByKey($fieldKey)?->retrieve($this->handler())->getValue();
    }
}
