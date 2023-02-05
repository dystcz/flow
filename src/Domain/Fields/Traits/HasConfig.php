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
     * @return mixed
     */
    public function getConfigKey(string $key): mixed
    {
        if (!array_key_exists($key, $this->getConfig())) {
            return null;
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
