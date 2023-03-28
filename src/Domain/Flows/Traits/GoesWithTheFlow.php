<?php

declare(strict_types=1);

namespace Dystcz\Flow\Domain\Flows\Traits;

use Dystcz\Flow\Domain\Fields\Contracts\FieldContract;
use Dystcz\Flow\Domain\Flows\Models\Step;
use Dystcz\Flow\Domain\Flows\Models\Template;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Arr;

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
     * Get step field value by step key and field key.
     */
    public function getStepFieldValueByKey(string $stepKey, string $fieldKey): mixed
    {
        /** @var Step|null $step */
        $step = $this->steps->where('key', $stepKey)->first();

        if (! $step) {
            return null;
        }

        $handler = $step->handler();

        /** @var FieldContract|null $field */
        $field = Arr::first($handler->fields(), fn (FieldContract $field) => $field->getKey() === $fieldKey);

        if (! $field) {
            return null;
        }

        return $field->retrieve($step->handler())->getValue();
    }
}
