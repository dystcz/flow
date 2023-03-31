<?php

declare(strict_types=1);

namespace Dystcz\Flow\Domain\Flows\Contracts;

use Dystcz\Flow\Domain\Fields\Contracts\FieldContract;

interface FlowStepContract
{
    /**
     * Initialise the handler class.
     */
    public function handler(): FlowHandlerContract;

    /**
     * Get step field by step key and field key.
     */
    public function getFields(): array;

    /**
     * Get step field by field key.
     */
    public function getFieldByKey(string $fieldKey): ?FieldContract;

    /**
     * Get step field value by field key.
     */
    public function getFieldValue(string $fieldKey): mixed;
}
