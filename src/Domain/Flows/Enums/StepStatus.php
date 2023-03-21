<?php

declare(strict_types=1);

namespace Dystcz\Flow\Domain\Flows\Enums;

use Dystcz\Flow\Domain\Flows\Contracts\StatusContract;

enum StepStatus: string implements StatusContract
{
    case OPEN = 'open';
    case CLOSED = 'closed';
    case FINISHED = 'finished';
    case HOLD = 'hold';

    /**
     * Get status label.
     */
    public function label(): string
    {
        return match ($this) {
            self::OPEN => __('enums.steps.status.open'),
            self::CLOSED => __('enums.steps.status.closed'),
            self::FINISHED => __('enums.steps.status.finished'),
            self::HOLD => __('enums.steps.status.hold'),
        };
    }
}
