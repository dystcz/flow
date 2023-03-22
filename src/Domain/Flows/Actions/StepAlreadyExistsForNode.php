<?php

declare(strict_types=1);

namespace Dystcz\Flow\Domain\Flows\Actions;

use Closure;
use Dystcz\Flow\Domain\Flows\Models\Node;
use Dystcz\Flow\Domain\Flows\Models\Step;

class StepAlreadyExistsForNode
{
    /**
     * Get blocking nodes for a given node.
     *
     * @param (Cllosure(Step, Node): bool)|null $condition
     */
    public function handle(Step $step, Node $node, ?Closure $callback = null): bool
    {
        return $callback
            ? $callback($step, $node)
            : $step->model->steps->contains('node_id', $node->id);
    }
}
