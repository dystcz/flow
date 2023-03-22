<?php

declare(strict_types=1);

namespace Dystcz\Flow\Domain\Fields\Traits;

use Dystcz\Flow\Domain\Fields\Fields\Field;

trait HasHelp
{
    public ?string $help = null;

    /**
     * Set help text.
     */
    public function setHelp(string $help): Field
    {
        $this->help = $help;

        return $this;
    }

    /**
     * Get help text.
     */
    public function getHelp(): ?string
    {
        return $this->help;
    }
}
