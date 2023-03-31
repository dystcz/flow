<?php

declare(strict_types=1);

namespace Dystcz\Flow\Domain\Flows\Contracts;

use Dystcz\Flow\Domain\Flows\Models\Step;
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
     * Get step field by step key.
     */
    public function getStepByKey(string $stepKey): ?Step;
}
