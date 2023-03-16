<?php

namespace Dystcz\Flow\Domain\Flows\Actions;

use Dystcz\Flow\Domain\Flows\Models\Node;
use Illuminate\Support\Collection;

class GetNextNodesForNode
{
    /**
     * Get next nodes for a given node.
     */
    public function handle(Node $node): Collection
    {
        return $node->children;
    }
}
