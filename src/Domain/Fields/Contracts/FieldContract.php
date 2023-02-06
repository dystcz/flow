<?php

namespace Dystcz\Process\Domain\Fields\Contracts;

use Closure;
use Dystcz\Process\Domain\Processes\Contracts\ProcessHandlerContract;

interface FieldContract
{
    /**
     * Get field handler.
     *
     * @return FieldHandlerContract
     */
    public function handler(): FieldHandlerContract;

    /**
     * Save field value.
     *
     * @param ProcessHandlerContract $handler
     * @param null|Closure $callback
     * @return void
     */
    public function save(ProcessHandlerContract $handler, ?Closure $callback = null): void;

    /**
     * Retrieve field value.
     *
     * @param ProcessHandlerContract $handler
     * @param null|Closure $callback
     * @return self
     */
    public function retrieve(ProcessHandlerContract $handler, ?Closure $callback = null): self;

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

    /**
     * To array.
     *
     * @return array
     */
    public function toArray(): array;
}
