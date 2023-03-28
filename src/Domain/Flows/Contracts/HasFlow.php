<?php

declare(strict_types=1);

namespace Dystcz\Flow\Domain\Flows\Contracts;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

interface HasFlow
{
    /**
     * Flow steps relation.
     */
    public function steps(): MorphMany;

    /**
     * Flow template relation.
     */
    public function template(): BelongsTo;

    /**
     * Get step field value by step key and field key.
     */
    public function getStepFieldValueByKey(string $stepKey, string $fieldKey): mixed;
}
