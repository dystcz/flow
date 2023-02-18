<?php

namespace Dystcz\Flow\Domain\Flows\Actions;

use Dystcz\Flow\Domain\Flows\Contracts\HasFlow;
use Dystcz\Flow\Domain\Flows\Data\StepData;
use Dystcz\Flow\Domain\Flows\Models\Node;
use Dystcz\Flow\Domain\Flows\Models\Step;
use Dystcz\Flow\Domain\Flows\Models\Template;
use Illuminate\Database\Eloquent\MassAssignmentException;

class InitializeStep
{
    /**
     * Create root node for a model and return it.
     *
     * @throws MassAssignmentException
     */
    public function handle(HasFlow $model, ?Node $node = null, ?Template $template = null): Step
    {
        $template = $template ?? $model->template;

        /** @var Node $node */
        $node = $node ?? $template->rootNode;

        /** @var Step $step */
        $step = $model
            ->steps()
            ->create(
                (new StepData(...[
                    'template_id' => $template->id,
                    'node_id' => $node->id,
                    'handler' => $node->handler,
                    'name' => $node->name,
                    'key' => $node->key,
                    'group' => $node->group,
                ]))->toArray()
            );

        return $step;
    }
}
