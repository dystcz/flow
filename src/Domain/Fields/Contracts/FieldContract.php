<?php

namespace Dystcz\Process\Domain\Fields\Contracts;

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

    /**
     * Get config value.
     *
     * @return mixed
     */
    public function getConfigValue(string $key): mixed;
}
