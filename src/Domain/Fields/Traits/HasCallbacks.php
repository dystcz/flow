<?php

declare(strict_types=1);

namespace Dystcz\Flow\Domain\Fields\Traits;

use Closure;
use Dystcz\Flow\Domain\Fields\Fields\Field;

trait HasCallbacks
{
    public ?Closure $retrieveCallback = null;

    public ?Closure $saveCallback = null;

    /**
     * Set save callback.
     */
    public function handleSave(Closure $saveCallback): Field
    {
        $this->saveCallback = $saveCallback;

        return $this;
    }

    /**
     * Set retrieve callback.
     */
    public function handleRetrieve(Closure $retrieveCallback): Field
    {
        $this->retrieveCallback = $retrieveCallback;

        return $this;
    }
}
