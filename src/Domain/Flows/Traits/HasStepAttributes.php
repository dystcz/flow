<?php

declare(strict_types=1);

namespace Dystcz\Flow\Domain\Flows\Traits;

use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\Config;
use Spatie\SchemalessAttributes\Casts\SchemalessAttributes;
use Spatie\SchemalessAttributes\SchemalessAttributesTrait;

trait HasStepAttributes
{
    use SchemalessAttributesTrait;

    /**
     * Get step attributes column name.
     */
    public static function stepAttributesField(): string
    {
        return Config::get('flow.steps.step_attributes_column', 'step_attributes');
    }

    /**
     * Cast step attributes as schemaless attributes.
     *
     * @see https://github.com/spatie/laravel-schemaless-attributes
     */
    public function initializeHasStepAttributes(): void
    {
        $this->casts[static::stepAttributesField()] = SchemalessAttributes::class;
    }

    /**
     * Scope with step attributes.
     */
    public function scopeWhereStepAttributes(): Builder
    {
        return $this->{static::stepAttributesField()}->modelScope();
    }
}
