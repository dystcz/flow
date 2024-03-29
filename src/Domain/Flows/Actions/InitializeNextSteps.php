<?php

declare(strict_types=1);

namespace Dystcz\Flow\Domain\Flows\Actions;

use Dystcz\Flow\Domain\Flows\Contracts\InvokeableHandler;
use Dystcz\Flow\Domain\Flows\Models\Node;
use Dystcz\Flow\Domain\Flows\Models\Step;
use Dystcz\Flow\Domain\Flows\Scopes\HideSkippedSteps;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

class InitializeNextSteps
{
    protected GetNextNodesForNode $getNextNodes;

    protected GetBlockingNodesForNode $getBlockingNodes;

    protected StepAlreadyExistsForNode $stepAlreadyExistsForNode;

    public function __construct(protected Step $step)
    {
        $this->getNextNodes = new GetNextNodesForNode();

        $this->getBlockingNodes = new GetBlockingNodesForNode();

        $this->stepAlreadyExistsForNode = new StepAlreadyExistsForNode();
    }

    /**
     * Initialize next steps.
     */
    public function handle(array|bool $forceInitSteps = false): void
    {
        $this->step->load([
            'model',
            'model.steps' => fn ($query) => $query->withoutGlobalScope(HideSkippedSteps::class),
            'node',
            'node.children',
            'node.parents',
            'users',
        ]);

        $handler = $this->step->handler();

        if ($this->step->handler() instanceof InvokeableHandler) {
            return;
        }

        if (! $this->step->node) {
            $handlerClass = $handler::class;
            Log::error("Step with handler \"{$handlerClass}\" does not belong to any node.");

            return;
        }

        $this->getInitializableNodes($forceInitSteps)->each(
            fn (Node $node) => (new InitializeStep)->handle($this->step->model, $node)
        );
    }

    /**
     * Get initializable nodes from step node graph.
     * We are looking for next nodes which are not yet initialized.
     */
    protected function getInitializableNodes(array|bool $forceInitSteps): Collection
    {
        return $this->getNextNodes($this->step->node)
            ->filter(function (Node $node) use ($forceInitSteps) {
                $blockingNodes = $this->getBlockingNodesForNode($node);
                $blockingSteps = $this->getModelStepsFromNodes($blockingNodes);

                // Do not init if step already exists
                if ($this->stepExistsForNode($node)) {
                    return false;
                }

                // Force initialize specific steps
                if (
                    (is_array($forceInitSteps) && in_array($node->handler, $forceInitSteps))
                        || (is_bool($forceInitSteps) && $forceInitSteps)
                ) {
                    return true;
                }

                // Force initialize regardless of blocking nodes
                if ($node->handler::forceInitialize($this->step->model)) {
                    return true;
                }

                // If some steps were not even initialized yet from nodes
                if ($blockingNodes->count() > $blockingSteps->count()) {
                    return false;
                }

                // Check if blocking steps are finished
                return $blockingSteps->reduce(function ($carry, Step $step) {
                    return $carry && ($step->isFinished() || $step->isSkipped());
                }, true);
            });
    }

    /**
     * Get next step nodes.
     */
    protected function getNextNodes(Node $node): Collection
    {
        return $this->getNextNodes->handle($node);
    }

    /**
     * Get blocking nodes for a node.
     */
    protected function getBlockingNodesForNode(Node $node): Collection
    {
        return $this->getBlockingNodes->handle($node);
    }

    /**
     * Get step models from nodes.
     *
     * @param  Collection<array-key,Node>  $nodes
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
        return $this->step->model->steps->firstWhere('node_id', $node->id);
    }

    /**
     * Check if step exists for a given node.
     */
    protected function stepExistsForNode(Node $node): bool
    {
        return $this->stepAlreadyExistsForNode->handle($this->step, $node);
    }
}
