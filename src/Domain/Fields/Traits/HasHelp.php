<?php

namespace Dystcz\Flow\Domain\Fields\Traits;

trait HasHelp
{
    public ?string $help = null;

    /**
     * Set help text.
     */
    public function setHelp(string $help): self
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
