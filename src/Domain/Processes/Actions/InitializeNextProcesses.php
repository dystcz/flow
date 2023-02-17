<?php

namespace Dystcz\Process\Domain\Processes\Actions;

use Dystcz\Process\Domain\Processes\Models\Process;
use Dystcz\Process\Domain\Processes\Models\ProcessNode;
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
            fn ($node) => (new InitializeProcess())->handle($this->process->model, $node)
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
            ->filter(function (ProcessNode $node) {
                $blockingProcesses = $this->getModelProcessesFromNodes(
                    $this->getBlockingNodesForNode($node),
                );

                // Do not init if process already exists
                if ($this->processExistsForNode($node)) {
                    return false;
                }

                // Do not init if process is not initializable
                if (!$node->handler_type::shouldInitialize($this->process->model)) {
                    return false;
                }

                // Check if blocking processes are complete
                return $blockingProcesses->reduce(function ($carry, Process $process) {
                    return $carry && $process->handler()->isComplete();
                }, true);
            });
    }

    /**
     * Get next process nodes.
     *
     * @param ProcessNode $node
     * @return Collection
     */
    protected function getNextProcessNodes(ProcessNode $node): Collection
    {
        return $node->children;
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
     * Get process models from nodes.
     *
     * @param Collection $nodes
     * @return Collection<Process>
     */
    protected function getModelProcessesFromNodes(Collection $nodes): Collection
    {
        return $this->process->model->processes->whereIn('key', $nodes->pluck('key'));
    }

    /**
     * Get model process from node.
     *
     * @param ProcessNode $node
     * @return ProcessNode|null
     */
    protected function getModelProcessFromNode(ProcessNode $node): ?ProcessNode
    {
        return $this->process->model->processes->firstWhere('key', $node->key);
    }

    /**
     * Check if process exists for a given node.
     *
     * @param ProcessNode $node
     * @return bool
     */
    protected function processExistsForNode(ProcessNode $node): bool
    {
        return $this->process->model->processes->contains('key', $node->key);
    }
}
