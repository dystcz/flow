<?php

namespace Dystcz\Process\Domain\Processes\Models;

use Closure;
use Dystcz\Process\Domain\Base\Models\Model;
use Dystcz\Process\Domain\Processes\Collections\ProcessCollection;
use Dystcz\Process\Domain\Processes\Contracts\ProcessContract;
use Dystcz\Process\Domain\Processes\Traits\HasCustomModelEvents;
use Dystcz\Process\Domain\Processes\Traits\HasProcessAttributes;
use Dystcz\Process\Domain\Processes\Traits\InteractsWithHandler;
use Dystcz\Process\Domain\Processes\Traits\InteractsWithMedia;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Config;
use Marcovo\LaravelDagModel\Models\Builder\QueryBuilder as Builder;
use Marcovo\LaravelDagModel\Models\Edge\IsEdgeInDagContract;
use Marcovo\LaravelDagModel\Models\IsVertexInDag;
use Spatie\MediaLibrary\HasMedia;

class Process extends Model implements ProcessContract, HasMedia
{
    use HasCustomModelEvents;
    use HasProcessAttributes;
    use InteractsWithHandler;
    use InteractsWithMedia;
    use IsVertexInDag;
    use SoftDeletes;

    protected $dates = [
        'closed_at',
        'finished_at',
    ];

    protected $observables = [
        'finished',
    ];

    /**
     * Get edge model.
     *
     * @return IsEdgeInDagContract
     */
    public function getEdgeModel(): IsEdgeInDagContract
    {
        return new ProcessEdge();
    }

    /**
     * Get separation column.
     *
     * @return null|Closure
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
     * Register Process eloquent collection.
     *
     * @param array $models
     * @return ProcessCollection
     */
    public function newCollection(array $models = []): ProcessCollection
    {
        return new ProcessCollection($models);
    }

    /**
     * Check wether process is open.
     *
     * @return bool
     */
    public function isOpen(): bool
    {
        return is_null($this->closed_at);
    }

    /**
     * Check wether process is finished.
     *
     * @return bool
     */
    public function isFinished(): bool
    {
        return !is_null($this->finished_at);
    }

    /**
     * Scope open processes.
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopeOpen(Builder $query): Builder
    {
        return $query->whereNull('closed_at');
    }

    /**
     * Scope closed processes.
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopeClosed(Builder $query): Builder
    {
        return $query->where('closed_at', '!=', null);
    }

    /**
     * Scope finished processes.
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopeFinished(Builder $query): Builder
    {
        return $query->where('finished_at', '!=', null);
    }

    /**
     * Scope unfinished processes.
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopeUnfinished(Builder $query): Builder
    {
        return $query->whereNull('finished_at');
    }

    /**
     * Model relation.
     *
     * @return MorphTo
     */
    public function model(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Process template relationship.
     *
     * @return BelongsTo
     */
    public function template(): BelongsTo
    {
        return $this->belongsTo(Config::get('process.templates.model'), 'process_template_id');
    }

    /**
     * ProcessNode relation.
     *
     * @return BelongsTo
     */
    public function node(): BelongsTo
    {
        return $this->belongsTo(Config::get('process.nodes.model'), 'process_node_id');
    }

    /**
     * Users relation.
     *
     * @return BelongsToMany
     */
    public function users(): BelongsToMany
    {
        return $this
            ->belongsToMany(Config::get('process.users.model') ?? Config::get('auth.providers.users.model'))
            ->withTimestamps();
    }
}
