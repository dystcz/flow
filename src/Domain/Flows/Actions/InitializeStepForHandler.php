<?php

declare(strict_types=1);

namespace Dystcz\Flow\Domain\Flows\Actions;

use Dystcz\Flow\Domain\Flows\Exceptions\NodeDoesNotExistException;
use Dystcz\Flow\Domain\Flows\Models\Node;
use Dystcz\Flow\Domain\Flows\Models\Step;

class InitializeStepForHandler
{
    protected GetNextNodesForNode $getNextNodes;

    protected StepAlreadyExistsForNode $stepAlreadyExistsForNode;

    protected InitializeStep $initializeStep;

    public function __construct(private Step $step)
    {
        $this->getNextNodes = new GetNextNodesForNode();

        $this->stepAlreadyExistsForNode = new StepAlreadyExistsForNode();

        $this->initializeStep = new InitializeStep();
    }

    /**
     * Initialize step for a handler.
     *
     * @param  class-string  $handler
     */
    public function handle(string $handler, bool $onlyChildrenNodes = false): void
    {
        $this->step->loadMissing([
            'model',
            'node',
            'template',
            'template.nodes',
        ]);

        $node = $onlyChildrenNodes
            ? $this->getNodeFromStep($handler)
            : $this->getNodeFromTemplate($handler);

        throw_unless($node, new NodeDoesNotExistException(
            "Node with handler \"{$handler}\" not found when conditionally initializing new steps.",
        ));

        $this->initializeStepForANode($node);
    }

    /**
     * Get node from template.
     *
     * @param  class-string  $handler
     */
    private function getNodeFromTemplate(string $handler): ?Node
    {
        return $this->step->template->nodes->firstWhere('handler', $handler);
    }

    /**
     * Get node from step.
     *
     * @param  class-string  $handler
     */
    private function getNodeFromStep(string $handler): ?Node
    {
        return $this->step->node;
    }

    /**
     * Initialize step for a node.
     */
    private function initializeStepForANode(Node $node): void
    {
        // Do not init if step already exists
        if ($this->stepAlreadyExistsForNode->handle($this->step, $node)) {

            return;
        }

        $this->initializeStep->handle($this->step->model, $node);
    }
}
