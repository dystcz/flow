<?php

namespace Dystcz\Flow\Domain\Flows\Models;

use Closure;
use Dystcz\Flow\Domain\Base\Models\Model;
use Dystcz\Flow\Domain\Flows\Collections\NodeCollection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Config;
use Marcovo\LaravelDagModel\Models\Edge\IsEdgeInDagContract;
use Marcovo\LaravelDagModel\Models\IsVertexInDag;
use Marcovo\LaravelDagModel\Models\IsVertexInDagContract;

class Node extends Model implements IsVertexInDagContract
{
    use IsVertexInDag;
    use SoftDeletes;

    /**
     * Get the table associated with the model.
     *
     * @return string
     */
    public function getTable()
    {
        return Config::get('flow.nodes.table_name', parent::getTable());
    }

    /**
     * Get edge model.
     */
    public function getEdgeModel(): IsEdgeInDagContract
    {
        return new NodeEdge();
    }

    /**
     * Get separation column.
     */
    public function getSeparationCondition(): ?Closure
    {
        return function ($query) {
            $query->where('template_id', '=', $this->template_id);
        };
    }

    /**
     * Register node eloquent collection.
     */
    public function newCollection(array $models = []): NodeCollection
    {
        return new NodeCollection($models);
    }

    /**
     * Flow template relationship.
     */
    public function template(): BelongsTo
    {
        return $this->belongsTo(Config::get('flow.templates.model'));
    }

    /**
     * Users relation.
     */
    public function users(): BelongsToMany
    {
        return $this
            ->belongsToMany(Config::get('flow.users.model') ?? Config::get('auth.providers.users.model'))
            ->withTimestamps();
    }
}
