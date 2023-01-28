<?php

namespace Dystcz\Process\Models;

use Dystcz\Process\Collections\ProcessTemplateCollection;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Config;

class ProcessTemplate extends Model
{
    use SoftDeletes;

    /**
     * Register process template eloquent collection.
     *
     * @param array $models
     * @return ProcessTemplateCollection
     */
    public function newCollection(array $models = []): ProcessTemplateCollection
    {
        return new ProcessTemplateCollection($models);
    }

    /**
     * Process nodes relation.
     *
     * @return HasMany
     */
    public function nodes(): HasMany
    {
        return $this->hasMany(Config::get('process.nodes.model'));
    }
}
