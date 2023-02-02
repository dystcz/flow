<?php

namespace Dystcz\Process\Contracts;

interface FieldContract
{
    /**
     * Set value.
     *
     * @return self
     */
    public function setValue(mixed $value): self;

    /**
     * Get value.
     *
     * @return mixed
     */
    public function getValue(): mixed;
}
