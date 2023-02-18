<?php

namespace Dystcz\Flow\Domain\Fields\Contracts;

use Closure;
use Dystcz\Flow\Domain\Flows\Contracts\FlowHandlerContract;

interface FieldContract
{
    /**
     * Get field handler.
     */
    public function handler(): FieldHandlerContract;

    /**
     * Save field value.
     */
    public function save(FlowHandlerContract $handler, ?Closure $callback = null): void;

    /**
     * Retrieve field value.
     */
    public function retrieve(FlowHandlerContract $handler, ?Closure $callback = null): self;

    /**
     * Get name.
     */
    public function getName(): string;

    /**
     * Get key.
     */
    public function getKey(): string;

    /**
     * Set value.
     */
    public function setValue(mixed $value): self;

    /**
     * Get value.
     */
    public function getValue(): mixed;

    /**
     * Get config value.
     */
    public function getConfigKey(string $key, mixed $default = null): mixed;

    /**
     * To array.
     */
    public function toArray(): array;
}
