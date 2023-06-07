<?php

declare(strict_types=1);

namespace Dystcz\Flow\Domain\Fields\Contracts;

use Closure;

interface DisabledFieldContract
{
    /**
     * Mark field as disabled when a condition is met.
     */
    public function disableWhen(Closure $callback): FieldContract;

    /**
     * Mark field as disabled unless a condition is met.
     */
    public function disableUnless(Closure $callback): FieldContract;

    /**
     * Mark field as disabled.
     */
    public function setDisabled(): self;

    /**
     * Determine if field is disabled.
     */
    public function isDisabled(): bool;
}
