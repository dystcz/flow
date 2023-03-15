<?php

namespace Dystcz\Flow\Domain\Flows\Models;

use Closure;
use Dystcz\Flow\Domain\Base\Models\Model;
use Dystcz\Flow\Domain\Flows\Collections\StepCollection;
use Dystcz\Flow\Domain\Flows\Contracts\FlowStepContract;
use Dystcz\Flow\Domain\Flows\Contracts\HasFlow;
use Dystcz\Flow\Domain\Flows\Traits\HasCustomModelEvents;
use Dystcz\Flow\Domain\Flows\Traits\HasStepAttributes;
use Dystcz\Flow\Domain\Flows\Traits\InteractsWithHandler;
use Dystcz\Flow\Domain\Flows\Traits\InteractsWithMedia;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Config;
use Marcovo\LaravelDagModel\Models\Builder\QueryBuilder as Builder;
use Marcovo\LaravelDagModel\Models\Edge\IsEdgeInDagContract;
use Marcovo\LaravelDagModel\Models\IsVertexInDag;
use Marcovo\LaravelDagModel\Models\IsVertexInDagContract;
use Spatie\MediaLibrary\HasMedia;

class Step extends Model implements FlowStepContract, IsVertexInDagContract, HasMedia
{
    use HasCustomModelEvents;
    use HasStepAttributes;
    use InteractsWithHandler;
    use IsVertexInDag;
    use SoftDeletes;
    use InteractsWithMedia;

    protected $dates = [
        'closed_at',
        'deadline',
        'finished_at',
        'saved_at',
    ];

    protected $observables = [
        'finished',
    ];

    /**
     * Get the table associated with the model.
     *
     * @return string
     */
    public function getTable()
    {
        return Config::get('flow.steps.table_name', parent::getTable());
    }

    /**
     * Get edge model.
     */
    public function getEdgeModel(): IsEdgeInDagContract
    {
        return new StepEdge();
    }

    /**
     * Get separation column.
     */
    public function getSeparationCondition(): ?Closure
    {
        return function ($query) {
            $query
                ->where('model_type', '=', $this->model_type)
                ->where('model_id', '=', $this->model_id);
        };
    }

    /**
     * Register step eloquent collection.
     */
    public function newCollection(array $models = []): StepCollection
    {
        return new StepCollection($models);
    }

    /**
     * Check wether step is open.
     */
    public function isOpen(): bool
    {
        return is_null($this->closed_at);
    }

    /**
     * Check wether step is finished.
     */
    public function isFinished(): bool
    {
        return ! is_null($this->finished_at);
    }

    /**
     * Scope open steps.
     */
    public function scopeOpen(Builder $query): Builder
    {
        return $query->whereNull('closed_at');
    }

    /**
     * Scope closed steps.
     */
    public function scopeClosed(Builder $query): Builder
    {
        return $query->where('closed_at', '!=', null);
    }

    /**
     * Scope finished steps.
     */
    public function scopeFinished(Builder $query): Builder
    {
        return $query->where('finished_at', '!=', null);
    }

    /**
     * Scope unfinished steps.
     */
    public function scopeUnfinished(Builder $query): Builder
    {
        return $query->whereNull('finished_at');
    }

    /**
     * Scope flow steps for a model.
     */
    public function scopeForModel(Builder $builder, HasFlow $model): Builder
    {
        return $builder
            ->where('model_id', $model->id)
            ->where('model_type', get_class($model));
    }

    /**
     * Scope flow steps with the same template as model.
     */
    public function scopeSameTemplateAs(Builder $builder, HasFlow $model): Builder
    {
        return $builder->where('template_id', $model->template_id);
    }

    /**
     * Model relation.
     */
    public function model(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Flow template relationship.
     */
    public function template(): BelongsTo
    {
        return $this->belongsTo(Config::get('flow.templates.model'), 'template_id');
    }

    /**
     * Node relation.
     */
    public function node(): BelongsTo
    {
        return $this->belongsTo(Config::get('flow.nodes.model'), 'node_id');
    }

    /**
     * Users relation.
     */
    public function users(): BelongsToMany
    {
        return $this
            ->belongsToMany(
                Config::get('flow.users.model') ?? Config::get('auth.providers.users.model'),
                Config::get('flow.steps.users.table_name'),
            )
            ->withTimestamps();
    }
}
