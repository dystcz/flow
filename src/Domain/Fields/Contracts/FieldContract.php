<?php

namespace Dystcz\Process\Domain\Fields\Contracts;

interface FieldContract
{
    /**
     * Get field handler.
     *
     * @return FieldHandlerContract
     */
    public function handler(): FieldHandlerContract;

    /**
     * Get name.
     *
     * @return string
     */
    public function getName(): string;

    /**
     * Get key.
     *
     * @return string
     */
    public function getKey(): string;

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
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public function getConfigKey(string $key, mixed $default = null): mixed;
}
