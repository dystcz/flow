<?php

namespace Dystcz\Flow\Domain\Flows\Models;

use Illuminate\Support\Facades\Config;
use Marcovo\LaravelDagModel\Models\Edge\PathCountAlgorithmEdge;
use Marcovo\LaravelDagModel\Models\IsVertexInDagContract;

class StepEdge extends PathCountAlgorithmEdge
{
    /**
     * Get the table associated with the model.
     *
     * @return string
     */
    public function getTable()
    {
        return Config::get('flow.steps.edges.table_name', parent::getTable());
    }

    /**
     * Get the vertex model.
     */
    public function getVertexModel(): IsVertexInDagContract
    {
        return new Step();
    }
}
