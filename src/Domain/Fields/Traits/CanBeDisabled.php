<?php

declare(strict_types=1);

namespace Dystcz\Flow\Domain\Fields\Traits;

use Closure;
use Dystcz\Flow\Domain\Fields\Fields\Field;
use Illuminate\Support\Traits\Conditionable;

trait CanBeDisabled
{
    use Conditionable;

    public bool $disabled = false;

    /**
     * Mark field as disabled when a condition is met.
     */
    public function disableWhen(Closure $callback): Field
    {
        $this->when($callback(), function (self $field) {
            $field->setDisabled();
        });

        return $this;
    }

    /**
     * Mark field as disabled unless a condition is met.
     */
    public function disableUnless(Closure $callback): Field
    {
        $this->unless($callback(), function (self $field) {
            $field->setDisabled();
        });

        return $this;
    }

    /**
     * Mark field as disabled.
     */
    public function setDisabled(): Field
    {
        $this->disabled = true;

        return $this;
    }

    /**
     * Determine if field is disabled.
     */
    public function isDisabled(): bool
    {
        return $this->disabled;
    }
}
