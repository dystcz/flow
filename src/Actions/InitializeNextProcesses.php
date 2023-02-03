<?php

namespace Dystcz\Process\Actions;

use Dystcz\Process\Models\Process;
use Dystcz\Process\Models\ProcessNode;
use Illuminate\Support\Collection;

class InitializeNextProcesses
{
    public function __construct(protected Process $process)
    {
    }

    /**
     * Initialize next processes.
     *
     * @param Process $process
     * @return void
     */
    public function handle(): void
    {
        $this->getInitializableNodes()->each(
            fn ($node) => (new InitializeProcess)->handle($this->process->model, $node)
        );
    }

    /**
     * Get initializable nodes from process node graph.
     *
     * @return Collection
     */
    protected function getInitializableNodes(): Collection
    {
        return $this->getNextProcessNodes($this->process->node)
            ->filter(function ($node) {
                $blockingProcesses = $this->getModelProcessesFromNodes(
                    $this->getBlockingNodesForNode($node),
                );

                return $blockingProcesses->reduce(function ($carry, $process) {
                    return $carry && $process->handler()->isFinished();
                }, true);
            });
    }

    /**
     * Get next process nodes.
     *
     * @param ProcessNode $currentNode
     * @return Collection
     */
    protected function getNextProcessNodes(ProcessNode $currentNode): Collection
    {
        return $currentNode->children;
    }

    /**
     * Get blocking nodes for a node.
     *
     * @param ProcessNode $node
     * @return Collection
     */
    protected function getBlockingNodesForNode(ProcessNode $node): Collection
    {
        return $node->parents;
    }

    /**
     * Get model processes from nodes.
     *
     * @param Collection $nodes
     * @return Collection
     */
    protected function getModelProcessesFromNodes(Collection $nodes): Collection
    {
        return $this->process->model->processes->whereIn('key', $nodes->pluck('key'));
    }
}
