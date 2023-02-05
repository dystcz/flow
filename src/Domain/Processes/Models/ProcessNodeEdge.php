<?php

namespace Dystcz\Process\Domain\Processes\Models;

use Marcovo\LaravelDagModel\Models\Edge\PathCountAlgorithmEdge;
use Marcovo\LaravelDagModel\Models\IsVertexInDagContract;

class ProcessNodeEdge extends PathCountAlgorithmEdge
{
    protected $table = 'process_node_edges';

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
