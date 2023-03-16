<?php

namespace Dystcz\Flow\Domain\Fields\Traits;

use Illuminate\Support\Str;

trait HasComponent
{
    public string $component = 'field';

    /**
     * Set component name on demand.
     */
    public function setComponent(string $component): self
    {
        $this->component = $component;

        return $this;
    }

    /**
     * Get component name.
     */
    public function getComponent(): string
    {
        return property_exists($this, 'component') ? $this->component : Str::lower(class_basename($this));
    }
}
