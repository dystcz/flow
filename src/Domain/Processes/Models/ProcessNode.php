<?php

namespace Dystcz\Process\Domain\Processes\Models;

use Closure;
use Dystcz\Process\Domain\Base\Models\Model;
use Dystcz\Process\Domain\Processes\Collections\ProcessNodeCollection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Config;
use Marcovo\LaravelDagModel\Models\Edge\IsEdgeInDagContract;
use Marcovo\LaravelDagModel\Models\IsVertexInDag;
use Marcovo\LaravelDagModel\Models\IsVertexInDagContract;

class ProcessNode extends Model implements IsVertexInDagContract
{
    use IsVertexInDag;
    use SoftDeletes;

    /**
     * Get edge model.
     *
     * @return IsEdgeInDagContract
     */
    public function getEdgeModel(): IsEdgeInDagContract
    {
        return new ProcessNodeEdge();
    }

    /**
     * Get separation column.
     *
     * @return null|Closure
     */
    public function getSeparationCondition(): ?Closure
    {
        return function ($query) {
            $query->where('process_template_id', '=', $this->process_template_id);
        };
    }

    /**
     * Register process node eloquent collection.
     *
     * @param array $models
     * @return ProcessNodeCollection
     */
    public function newCollection(array $models = []): ProcessNodeCollection
    {
        return new ProcessNodeCollection($models);
    }

    /**
     * Process template relationship.
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
