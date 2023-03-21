<?php

declare(strict_types=1);

namespace Dystcz\Flow\Domain\Flows\Traits;

use Dystcz\Flow\Domain\Flows\Contracts\StatusContract;
use Dystcz\Flow\Domain\Flows\Enums\StepStatus;
use Marcovo\LaravelDagModel\Models\Builder\QueryBuilder as Builder;

trait HasStatus
{
    /**
     * Boot trait.
     */
    public static function bootHasStatus(): void
    {
    }

    /**
     * Set status attribute.
     */
    public function setStatus(StepStatus $status): void
    {
        $this->setAttribute('status', $status);
    }

    /**
     * Update status attribute.
     */
    public function updateStatus(StepStatus $status): void
    {
        $this->update(['status' => $status]);
    }

    /**
     * Determine if model status is same as the given status.
     */
    public function hasStatus(StepStatus $status): bool
    {
        return $this->status === $status;
    }

    /**
     * Scope by given status.
     */
    public function scopeStatus(Builder $builder, StepStatus $status): Builder
    {
        return $builder->where('status', $status);
    }

    /**
     * Scope by multiple statuses.
     *
     * @param array<StatusContract>
     */
    public function scopeStatuses(Builder $builder, array $statuses): Builder
    {
        return $builder->whereIn('status', $statuses);
    }
}
