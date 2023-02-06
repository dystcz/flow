<?php

namespace Dystcz\Process\Domain\Processes\Traits;

use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\Config;
use Spatie\SchemalessAttributes\Casts\SchemalessAttributes;
use Spatie\SchemalessAttributes\SchemalessAttributesTrait;

trait HasProcessAttributes
{
    use SchemalessAttributesTrait;

    /**
     * Get process attributes column name.
     *
     * @return string
     */
    public static function processAttributesField(): string
    {
        return Config::get('process.processes.process_attributes_column', 'process_attributes');
    }

    /**
     * Cast process attributes as schemaless attributes.
     * @see https://github.com/spatie/laravel-schemaless-attributes
     *
     * @return void
     */
    public function initializeHasProcessAttributes(): void
    {
        $this->casts[static::processAttributesField()] = SchemalessAttributes::class;
    }

    /**
     * Scope with process attributes.
     *
     * @return Builder
     */
    public function scopeWhereProcessAttributes(): Builder
    {
        return $this->{static::processAttributesField()}->modelScope();
    }
}
