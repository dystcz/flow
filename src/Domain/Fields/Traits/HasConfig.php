<?php

namespace Dystcz\Process\Domain\Fields\Traits;

trait HasConfig
{
    public array $config = [];

    /**
     * Set config value.
     *
     * @return self
     */
    public function setConfigKey(string $key, mixed $value): self
    {
        $this->config[$key] = $value;

        return $this;
    }

    /**
     * Get config value.
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public function getConfigKey(string $key, mixed $default = null): mixed
    {
        if (!array_key_exists($key, $this->getConfig())) {
            return $default;
        }

        return $this->getConfig()[$key];
    }

    /**
     * Get config.
     *
     * @return array
     */
    public function getConfig(): array
    {
        return $this->config;
    }
}