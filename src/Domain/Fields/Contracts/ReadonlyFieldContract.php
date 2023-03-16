<?php

namespace Dystcz\Flow\Domain\Fields\Contracts;

interface ReadonlyFieldContract
{
    /**
     * Mark field as readonly.
     */
    public function setReadonly(): self;

    /**
     * Determine if field is readonly.
     */
    public function isReadonly(): bool;
}
