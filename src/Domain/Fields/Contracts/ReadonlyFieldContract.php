<?php

declare(strict_types=1);

namespace Dystcz\Flow\Domain\Fields\Contracts;

interface ReadonlyFieldContract
{
    /**
     * Mark field as readonly.
     */
    public function setReadonly(): FieldContract;

    /**
     * Determine if field is readonly.
     */
    public function isReadonly(): bool;
}
