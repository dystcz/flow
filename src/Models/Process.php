<?php

namespace Dystcz\Process\Models;

use Closure;
use Dystcz\Process\Casts\FieldData;
use Dystcz\Process\Collections\ProcessCollection;
use Dystcz\Process\Contracts\ProcessContract;
use Dystcz\Process\Traits\InteractsWithHandler;
use Dystcz\Process\Traits\InteractsWithMedia;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Marcovo\LaravelDagModel\Models\Edge\IsEdgeInDagContract;
use Marcovo\LaravelDagModel\Models\IsVertexInDag;
use Spatie\MediaLibrary\HasMedia;

class Process extends Model implements ProcessContract, HasMedia
{
    use InteractsWithHandler;
    use InteractsWithMedia;
    use SoftDeletes;
    use IsVertexInDag;

    protected $casts = [
        'data' => FieldData::class,
        'open' => 'boolean',
        'finished' => 'boolean',
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
        return $this->open;
    }

    /**
     * Check wether process is finished.
     *
     * @return bool
     */
    public function isFinished(): bool
    {
        return $this->finished;
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
        return $this->belongsTo(ProcessTemplate::class, 'process_template_id');
    }

    /**
     * ProcessNode relation.
     *
     * @return BelongsTo
     */
    public function node(): BelongsTo
    {
        return $this->belongsTo(ProcessNode::class, 'process_node_id');
    }
}
