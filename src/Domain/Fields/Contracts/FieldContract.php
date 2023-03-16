<?php

namespace Dystcz\Flow\Domain\Fields\Contracts;

use Dystcz\Flow\Domain\Flows\Contracts\FlowHandlerContract;

interface FieldContract extends ReadonlyFieldContract, FieldWithHelpContract, FieldWithConfigContract, FieldWithComponentContract
{
    /**
     * Get field handler.
     */
    public function handler(): FieldHandlerContract;

    /**
     * Save field value.
     */
    public function save(FlowHandlerContract $handler): void;

    /**
     * Retrieve field value.
     */
    public function retrieve(FlowHandlerContract $handler): self;

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
