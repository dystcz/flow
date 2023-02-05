<?php

namespace Dystcz\Process\Domain\Fields\Traits;

use Illuminate\Support\Str;

trait HasComponent
{
    public string $component = 'field';

    /**
     * Set component name on demand.
     *
     * @param string $component
     * @return void
     */
    public function setComponent(string $component): void
    {
        $this->component = $component;
    }

    /**
     * Get component name.
     *
     * @return string
     */
    public function getComponent(): string
    {
        return property_exists($this, 'component') ? $this->component : Str::lower(class_basename($this));
    }
}
