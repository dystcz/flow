<?php

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
}
