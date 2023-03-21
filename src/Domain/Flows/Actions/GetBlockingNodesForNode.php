<?php

declare(strict_types=1);

namespace Dystcz\Flow\Domain\Flows\Actions;

use Dystcz\Flow\Domain\Flows\Models\Node;
use Illuminate\Support\Collection;

class GetBlockingNodesForNode
{
    /**
     * Get blocking nodes for a given node.
     */
    public function handle(Node $node): Collection
    {
        return $node->parents;
    }
}
