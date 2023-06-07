<?php

declare(strict_types=1);

namespace Dystcz\Flow\Domain\Fields\Contracts;

interface FieldWithComponentContract
{
    /**
     * Set component name on demand.
     */
    public function setComponent(string $component): FieldContract;

    /**
     * Get component name.
     */
    public function getComponent(): string;
}
