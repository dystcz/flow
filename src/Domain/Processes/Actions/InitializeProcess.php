<?php

namespace Dystcz\Process\Domain\Processes\Actions;

use Dystcz\Process\Domain\Processes\Contracts\Processable;
use Dystcz\Process\Domain\Processes\Data\ProcessData;
use Dystcz\Process\Domain\Processes\Models\Process;
use Dystcz\Process\Domain\Processes\Models\ProcessNode;
use Dystcz\Process\Domain\Processes\Models\ProcessTemplate;
use Illuminate\Database\Eloquent\MassAssignmentException;

class InitializeProcess
{
    /**
     * Create root process node for a model and return it.
     *
     * @param Processable $model
     * @param null|ProcessNode $node
     * @param null|ProcessTemplate $template
     * @return Process
     * @throws MassAssignmentException
     */
    public function handle(Processable $model, ?ProcessNode $node = null, ?ProcessTemplate $template = null): Process
    {
        $template = $template ?? $model->processTemplate;

        /** @var ProcessNode $node */
        $node = $node ?? $template->rootNode;

        /** @var Process $process */
        $process = $model
            ->processes()
            ->create(
                (new ProcessData(...[
                    'process_template_id' => $template->id,
                    'process_node_id' => $node->id,
                    'handler_type' => $node->handler_type,
                    'name' => $node->name,
                    'key' => $node->key,
                    'group' => $node->group,
                ]))->toArray()
            );

        // Sync node users to process users
        $process->users()->sync($node->users->pluck('id')->toArray());

        return $process;
    }
}
