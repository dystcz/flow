<?php

declare(strict_types=1);

namespace Dystcz\Flow\Domain\Fields\Traits;

use Dystcz\Flow\Domain\Fields\Fields\Field;
use Illuminate\Support\Str;

trait HasComponent
{
    public string $component = 'field';

    /**
     * Set component name on demand.
     */
    public function setComponent(string $component): Field
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
