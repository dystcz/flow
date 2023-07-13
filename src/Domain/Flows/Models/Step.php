<?php

declare(strict_types=1);

namespace Dystcz\Flow\Domain\Flows\Models;

use Closure;
use Dystcz\Flow\Domain\Base\Models\Model;
use Dystcz\Flow\Domain\Flows\Builders\StepBuilder;
use Dystcz\Flow\Domain\Flows\Collections\StepCollection;
use Dystcz\Flow\Domain\Flows\Contracts\FlowStepContract;
use Dystcz\Flow\Domain\Flows\Contracts\Notifiable;
use Dystcz\Flow\Domain\Flows\Enums\StepStatus;
use Dystcz\Flow\Domain\Flows\Traits\HasCustomModelEvents;
use Dystcz\Flow\Domain\Flows\Traits\HasStatus;
use Dystcz\Flow\Domain\Flows\Traits\HasStepAttributes;
use Dystcz\Flow\Domain\Flows\Traits\InteractsWithHandler;
use Dystcz\Flow\Domain\Flows\Traits\InteractsWithMedia;
use Dystcz\Flow\Domain\Flows\Traits\InteractsWithNotifications;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Config;
use Marcovo\LaravelDagModel\Models\Edge\IsEdgeInDagContract;
use Marcovo\LaravelDagModel\Models\IsVertexInDag;
use Marcovo\LaravelDagModel\Models\IsVertexInDagContract;
use Spatie\MediaLibrary\HasMedia;

class Step extends Model implements FlowStepContract, IsVertexInDagContract, HasMedia, Notifiable
{
    use HasCustomModelEvents;
    use HasStatus;
    use HasStepAttributes;
    use InteractsWithHandler;
    use InteractsWithMedia;
    use InteractsWithNotifications;
    use IsVertexInDag;
    use SoftDeletes;

    protected $observables = [
        'finishing',
        'finished',
    ];

    protected $casts = [
        'status' => StepStatus::class,
        'closed_at' => 'datetime',
        'finished_at' => 'datetime',
        'saved_at' => 'datetime',
        'deadline' => 'datetime',
        'meta' => 'array',
    ];

    /**
     * Get the table associated with the model.
     */
    public function getTable(): string
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
     * Register eloquent builder.
     */
    public function newEloquentBuilder($query): StepBuilder
    {
        return new StepBuilder($query);
    }

    /**
     * Check wether step is open.
     */
    public function isOpen(): bool
    {
        return $this->status === StepStatus::OPEN;
    }

    /**
     * Check wether step is finished.
     */
    public function isFinished(): bool
    {
        return $this->status === StepStatus::FINISHED;
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
