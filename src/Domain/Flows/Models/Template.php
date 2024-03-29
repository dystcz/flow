<?php

declare(strict_types=1);

namespace Dystcz\Flow\Domain\Flows\Models;

use Dystcz\Flow\Domain\Base\Models\Model;
use Dystcz\Flow\Domain\Flows\Collections\TemplateCollection;
use Dystcz\Flow\Domain\Flows\Scopes\WithoutHiddenTemplates;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Config;

class Template extends Model
{
    use SoftDeletes;

    /**
     * The "booted" method of the model.
     */
    protected static function booted(): void
    {
        // static::addGlobalScope(new WithoutHiddenTemplates);
    }

    /**
     * Get the table associated with the model.
     */
    public function getTable(): string
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

    public function scopeWithoutHidden(Builder $query): Builder
    {
        return $query->whereNotIn('group', Config::get('flow.templates.hidden_groups', []));
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
