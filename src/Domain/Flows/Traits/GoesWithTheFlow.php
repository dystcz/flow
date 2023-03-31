<?php

declare(strict_types=1);

namespace Dystcz\Flow\Domain\Flows\Traits;

use Dystcz\Flow\Domain\Flows\Models\Step;
use Dystcz\Flow\Domain\Flows\Models\Template;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait GoesWithTheFlow
{
    /**
     * Flow steps relation.
     */
    public function steps(): MorphMany
    {
        return $this->morphMany(Step::class, 'model');
    }

    /**
     * Flow template relation.
     */
    public function template(): BelongsTo
    {
        return $this->belongsTo(Template::class);
    }

    /**
     * Get step field by step key.
     */
    public function getStepByKey(string $stepKey): ?Step
    {
        /** @var Step|null $step */
        return $this->steps->where('key', $stepKey)->first();
    }
}
