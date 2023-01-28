<?php

namespace Dystcz\Process\Models;

use Marcovo\LaravelDagModel\Models\Edge\PathCountAlgorithmEdge;
use Marcovo\LaravelDagModel\Models\IsVertexInDagContract;

class ProcessEdge extends PathCountAlgorithmEdge
{
    protected $table = 'process_edges';

    /**
     * Get the vertex model.
     *
     * @return IsVertexInDagContract
     */
    public function getVertexModel(): IsVertexInDagContract
    {
        return new ProcessNode();
    }
}
