<?php

namespace Dystcz\Flow\Domain\Flows\Models;

use Illuminate\Support\Facades\Config;
use Marcovo\LaravelDagModel\Models\Edge\PathCountAlgorithmEdge;
use Marcovo\LaravelDagModel\Models\IsVertexInDagContract;

class NodeEdge extends PathCountAlgorithmEdge
{
    /**
     * Get the table associated with the model.
     *
     * @return string
     */
    public function getTable()
    {
        return Config::get('flow.nodes.edges.table_name', parent::getTable());
    }

    /**
     * Get the vertex model.
     */
    public function getVertexModel(): IsVertexInDagContract
    {
        return new Node();
    }
}
