<?php

namespace Dystcz\Process\Domain\Processes\Models;

use Dystcz\Process\Domain\Base\Models\Model;
use Dystcz\Process\Domain\Processes\Collections\ProcessTemplateCollection;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
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

    /**
     * Root node.
     *
     * @return HasMany
     */
    public function rootNode(): HasOne
    {
        return $this
            ->hasOne(Config::get('process.nodes.model'))
            ->whereDoesntHave('parents');
    }
}
