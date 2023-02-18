<?php

namespace Dystcz\Flow\Domain\Flows\Actions;

use Dystcz\Flow\Domain\Flows\Models\Node;
use Dystcz\Flow\Domain\Flows\Models\Step;
use Illuminate\Support\Collection;

class InitializeNextSteps
{
    public function __construct(protected Step $step)
    {
    }

    /**
     * Initialize next steps.
     */
    public function handle(): void
    {
        $this->getInitializableNodes()->each(
            fn ($node) => (new InitializeStep())->handle($this->step->model, $node)
        );
    }

    /**
     * Get initializable nodes from step node graph.
     */
    protected function getInitializableNodes(): Collection
    {
        return $this->getNextNodes($this->step->node)
            ->filter(function (Node $node) {
                $blockingNodes = $this->getBlockingNodesForNode($node);
                $blockingSteps = $this->getModelStepsFromNodes($blockingNodes);

                // If some steps were not even initialized yet from nodes
                if ($blockingNodes->count() > $blockingSteps->count()) {
                    return false;
                }

                // Do not init if step already exists
                if ($this->stepExistsForNode($node)) {
                    return false;
                }

                // Do not init if step is not initializable
                if (! $node->handler_type::shouldInitialize($this->step->model)) {
                    return false;
                }

                // Check if blocking steps are finished
                return $blockingSteps->reduce(function ($carry, Step $step) {
                    return $carry && $step->isFinished();
                }, true);
            });
    }

    /**
     * Get next step nodes.
     */
    protected function getNextNodes(Node $node): Collection
    {
        return $node->children;
    }

    /**
     * Get blocking nodes for a node.
     */
    protected function getBlockingNodesForNode(Node $node): Collection
    {
        return $node->parents;
    }

    /**
     * Get step models from nodes.
     *
     * @return Collection<Step>
     */
    protected function getModelStepsFromNodes(Collection $nodes): Collection
    {
        return $this->step->model->steps->whereIn('node_id', $nodes->pluck('id'));
    }

    /**
     * Get model step from node.
     */
    protected function getModelStepFromNode(Node $node): ?Node
    {
        return $this->step->model->steps->firstWhere('id', $node->id);
    }

    /**
     * Check if step exists for a given node.
     */
    protected function stepExistsForNode(Node $node): bool
    {
        return $this->step->model->steps->contains('id', $node->id);
    }
}
