<?php

declare(strict_types=1);

namespace Dystcz\Flow\Domain\Fields\Contracts;

use Closure;
use Dystcz\Flow\Domain\Fields\Fields\Field;

interface DisabledFieldContract
{
    /**
     * Mark field as disabled when a condition is met.
     */
    public function disableWhen(Closure $callback): Field;

    /**
     * Mark field as disabled unless a condition is met.
     */
    public function disableUnless(Closure $callback): Field;

    /**
     * Mark field as disabled.
     */
    public function setDisabled(): Field;

    /**
     * Determine if field is disabled.
     */
    public function isDisabled(): bool;
}
