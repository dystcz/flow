<?php

declare(strict_types=1);

namespace Dystcz\Flow\Domain\Fields\Contracts;

use Dystcz\Flow\Domain\Fields\Fields\Field;

interface FieldWithComponentContract
{
    /**
     * Set component name on demand.
     */
    public function setComponent(string $component): Field;

    /**
     * Get component name.
     */
    public function getComponent(): string;
}
