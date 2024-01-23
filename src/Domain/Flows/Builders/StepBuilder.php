<?php

declare(strict_types=1);

namespace Dystcz\Flow\Domain\Flows\Builders;

use Dystcz\Flow\Domain\Flows\Contracts\HasFlow;
use Dystcz\Flow\Domain\Flows\Enums\StepStatus;
use Illuminate\Database\Eloquent\Builder;

class StepBuilder extends Builder
{
    /**
     * Scope open steps.
     */
    public function open(): self
    {
        return $this->where('status', StepStatus::OPEN);
    }

    /**
     * Scope closed steps.
     */
    public function closed(): self
    {
        return $this->where('status', StepStatus::CLOSED);
    }

    /**
     * Scope finished steps.
     */
    public function finished(): self
    {
        return $this->whereIn(
            'status',
            [StepStatus::FINISHED, StepStatus::HOLD],
        );
    }

    /**
     * Scope unfinished steps.
     */
    public function unfinished(): self
    {
        return $this->where('status', '!=', StepStatus::FINISHED);
    }

    /**
     * Scope flow steps for a model.
     */
    public function forModel(HasFlow $model): self
    {
        return $this
            ->where('model_id', $model->id)
            ->where('model_type', get_class($model));
    }

    /**
     * Scope flow steps for a model.
     */
    public function forModelById(int $modelId, string $modelClass): self
    {
        return $this
            ->where('model_id', $modelId)
            ->where('model_type', $modelClass);
    }

    /**
     * Scope flow steps with the same template id.
     */
    public function sameTemplateByForeignKey(string $modelClass): self
    {
        $table = (new $modelClass)->getTable();

        return $this->where('template_id', "{$table}.template_id");
    }

    /**
     * Scope flow steps with the same template as model.
     */
    public function sameTemplateAs(HasFlow $model): self
    {
        return $this->where('template_id', $model->template_id);
    }
}
