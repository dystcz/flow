<?php

namespace Dystcz\Flow\Domain\Fields\Contracts;

use Dystcz\Flow\Domain\Fields\Fields\Field;

interface FieldWithHelpContract
{
    /**
     * Set help text.
     */
    public function setHelp(string $help): Field;

    /**
     * Get help text.
     */
    public function getHelp(): ?string;
}
