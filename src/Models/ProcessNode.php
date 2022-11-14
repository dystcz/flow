<?php

namespace Dystcz\Process\Models;

use Dystcz\Process\Collections\ProcessNodeCollection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Config;
use Kalnoy\Nestedset\NodeTrait;

class ProcessNode extends Model
{
    use NodeTrait;
    use SoftDeletes;

    /**
     * Register ProcessNodeeloquent collection.
     *
     * @param array $models
     * @return ProcessNodeCollection
     */
    public function newCollection(array $models = []): ProcessNodeCollection
    {
        return new ProcessNodeCollection($models);
    }

    /**
     * ProcessTemplate relationship.
     *
     * @return BelongsTo
     */
    public function template(): BelongsTo
    {
        return $this->belongsTo(Config::get('process.templates.model'));
    }

    /**
     * Nodes that need to be finished in order to open this process.
     *
     * @return HasMany
     */
    public function blockingNodes(): HasMany
    {
        return $this->hasMany(Config::get('process.nodes.model'));
    }

    /**
     * Responsible people relation.
     *
     * @return MorphToMany
     */
    public function responsiblePeople(): MorphToMany
    {
        return $this->morphToMany(
            Config::get('process.config.responsible_person_model'),
            'responsiblePeople',
            'process_responsibles'
        );
    }

    /**
     * Notifiable people relation.
     *
     * @return MorphToMany
     */
    public function notifiablePeople(): MorphToMany
    {
        return $this->morphToMany(
            Config::get('process.config.notifiable_person_model'),
            'notifiablePeople',
            'process_notifiables'
        );
    }
}
