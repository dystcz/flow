<?php

namespace Dystcz\Flow\Domain\Flows\Traits;

use Dystcz\Flow\Domain\Flows\Enums\StepStatus;
use Marcovo\LaravelDagModel\Models\Builder\QueryBuilder as Builder;

trait HasStatus
{
    /**
     * Set status attribute.
     */
    public function setStatus(StepStatus $status): void
    {
        $this->setAttribute('status', $status->value);
    }

    /**
     * Update status attribute.
     */
    public function updateStatus(StepStatus $status): void
    {
        $this->update(['status' => $status->value]);
    }

    /**
     * Determine if model status is same as the given status.
     */
    public function hasStatus(StepStatus $status): bool
    {
        return StepStatus::tryFrom($this->status) === $status;
    }

    /**
     * Scope by given status.
     */
    public function scopeStatus(Builder $builder, StepStatus $status): Builder
    {
        return $builder->where('status', $status->value);
    }

    /**
     * Scope by multiple statuses.
     */
    public function scopeStatuses(Builder $builder, array $statuses): Builder
    {
        return $builder->whereIn('status', array_map(fn (StepStatus $status) => $status->value, $statuses));
    }
}
