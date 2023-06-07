<?php

declare(strict_types=1);

namespace Dystcz\Flow\Domain\Fields\Contracts;

interface FieldWithHelpContract
{
    /**
     * Set help text.
     */
    public function setHelp(string $help): FieldContract;

    /**
     * Get help text.
     */
    public function getHelp(): ?string;
}
