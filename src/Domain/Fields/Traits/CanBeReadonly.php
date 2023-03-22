<?php

declare(strict_types=1);

namespace Dystcz\Flow\Domain\Fields\Traits;

use Dystcz\Flow\Domain\Fields\Fields\Field;

trait CanBeReadonly
{
    public bool $readonly = false;

    /**
     * Mark field as readonly.
     */
    public function setReadonly(): Field
    {
        $this->readonly = true;

        return $this;
    }

    /**
     * Determine if field is readonly.
     */
    public function isReadonly(): bool
    {
        return $this->readonly;
    }
}
