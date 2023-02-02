<?php

namespace Dystcz\Process\Actions;

use Dystcz\Process\Contracts\Processable;
use Dystcz\Process\Data\ProcessData;
use Dystcz\Process\Models\Process;
use Dystcz\Process\Models\ProcessNode;
use Dystcz\Process\Models\ProcessTemplate;
use Illuminate\Database\Eloquent\MassAssignmentException;

class InitializeProcess
{
    /**
     * Create root process node for a model and return it.
     *
     * @param Processable $model
     * @param null|ProcessTemplate $template
     * @return Process
     * @throws MassAssignmentException
     */
    public function handle(Processable $model, ?ProcessTemplate $template = null): Process
    {
        $template = $template ?? $model->processTemplate;

        /** @var ProcessNode $node */
        $node = $template->rootNode;

        /** @var Process $process */
        $process = $model
            ->processes()
            ->create(
                ProcessData::from([
                    'process_template_id' => $template->id,
                    'process_node_id' => $node->id,
                    'handler' => $node->handler,
                    'name' => $node->name,
                    'key' => $node->key,
                    'group' => $node->group,
                ])->toArray()
            );

        return $process;
    }
}
