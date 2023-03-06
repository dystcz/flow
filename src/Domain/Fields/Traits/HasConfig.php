<?php

namespace Dystcz\Flow\Domain\Fields\Traits;

trait HasConfig
{
    public array $config = [];

    /**
     * Set config value.
     */
    public function setConfigKey(string $key, mixed $value): self
    {
        $this->config[$key] = $value;

        return $this;
    }

    /**
     * Get config value.
     *
     * @param  mixed  $default
     */
    public function getConfigKey(string $key, mixed $default = null): mixed
    {
        if (! array_key_exists($key, $this->getConfig())) {
            return $default;
        }

        return $this->getConfig()[$key];
    }

    /**
     * Set config.
     */
    public function setConfig(array $config): self
    {
        $this->config = $config;

        return $this;
    }

    /**
     * Get config.
     */
    public function getConfig(): array
    {
        return $this->config;
    }
}
