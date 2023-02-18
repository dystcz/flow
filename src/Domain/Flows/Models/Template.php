<?php

namespace Dystcz\Flow\Domain\Flows\Models;

use Dystcz\Flow\Domain\Base\Models\Model;
use Dystcz\Flow\Domain\Flows\Collections\TemplateCollection;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Config;

class Template extends Model
{
    use SoftDeletes;

    /**
     * Get the table associated with the model.
     *
     * @return string
     */
    public function getTable()
    {
        return Config::get('flow.templates.table_name', parent::getTable());
    }

    /**
     * Register flow template eloquent collection.
     */
    public function newCollection(array $models = []): TemplateCollection
    {
        return new TemplateCollection($models);
    }

    /**
     * Flow nodes relation.
     */
    public function nodes(): HasMany
    {
        return $this->hasMany(Config::get('flow.nodes.model'));
    }

    /**
     * Root node.
     *
     * @return HasMany
     */
    public function rootNode(): HasOne
    {
        return $this
            ->hasOne(Config::get('flow.nodes.model'))
            ->whereDoesntHave('parents');
    }
}
