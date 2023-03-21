<?php

declare(strict_types=1);

namespace Dystcz\Flow\Domain\Fields\Contracts;

use Dystcz\Flow\Domain\Fields\Fields\Field;

interface FieldWithConfigContract
{
    /**
     * Set config value.
     */
    public function setConfigKey(string $key, mixed $value): Field;

    /**
     * Get config value.
     *
     * @param  mixed  $default
     */
    public function getConfigKey(string $key, mixed $default = null): mixed;

    /**
     * Set config.
     */
    public function setConfig(array $config): Field;

    /**
     * Get config.
     */
    public function getConfig(): array;
}
