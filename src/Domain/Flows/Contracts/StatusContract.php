<?php

declare(strict_types=1);

namespace Dystcz\Flow\Domain\Flows\Contracts;

interface StatusContract
{
    /**
     * Get status label.
     */
    public function label(): string;
}
