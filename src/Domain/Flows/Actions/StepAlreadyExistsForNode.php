<?php

declare(strict_types=1);

namespace Dystcz\Flow\Domain\Flows\Actions;

use Dystcz\Flow\Domain\Flows\Models\Node;
use Dystcz\Flow\Domain\Flows\Models\Step;

class StepAlreadyExistsForNode
{
    /**
     * Get blocking nodes for a given node.
     */
    public function handle(Step $step, Node $node): bool
    {
        return $step->model->steps->contains('node_id', $node->id);
    }
}
