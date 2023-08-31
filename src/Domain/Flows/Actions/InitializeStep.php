<?php

declare(strict_types=1);

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
    public function handle(HasFlow $model, Node $node = null, Template $template = null): Step
    {
        $template = $template ?? $model->template;

        /** @var Node $node */
        $node = $node ?? $template->rootNode;

        $data = (new StepData(...[
            'template_id' => $template->id,
            'node_id' => $node->id,
            'handler' => $node->handler,
            'name' => $node->name,
            'key' => $node->key,
            'group' => $node->group,
            'meta' => $node->meta,
        ]));

        /** @var Step $step */
        $step = $model
            ->steps()
            ->create($data->toArray());

        // Early return if step is forced to initialize
        if ($node->handler::forceInitialize($model)) {
            return $step;
        }

        // Skip step if not initializable
        if (! $node->handler::shouldInitialize($model)) {
            $this->skipStepAfterInitialization($step);
        }

        return $step;
    }

    /**
     * Skip step after initialization.
     */
    protected function skipStepAfterInitialization(Step $step): void
    {
        // If the skipping event returns false, cancel the
        // skip operation so it can be cancelled by validation for example.
        if ($step->fireSkippingEvent() === false) {
            return;
        }

        $step->fireSkippedEvent();
    }
}
