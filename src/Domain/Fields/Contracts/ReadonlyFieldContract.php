<?php

namespace Dystcz\Flow\Domain\Fields\Contracts;

use Dystcz\Flow\Domain\Fields\Fields\Field;

interface ReadonlyFieldContract
{
    /**
     * Mark field as readonly.
     */
    public function setReadonly(): Field;

    /**
     * Determine if field is readonly.
     */
    public function isReadonly(): bool;
}
