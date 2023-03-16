<?php

namespace Dystcz\Flow\Domain\Fields\Traits;

use Closure;

trait HasCallbacks
{
    public ?Closure $retrieveCallback = null;

    public ?Closure $saveCallback = null;

    /**
     * Set save callback.
     */
    public function handleSave(Closure $saveCallback): self
    {
        $this->saveCallback = $saveCallback;

        return $this;
    }

    /**
     * Set retrieve callback.
     */
    public function handleRetrieve(Closure $retrieveCallback): self
    {
        $this->retrieveCallback = $retrieveCallback;

        return $this;
    }
}
