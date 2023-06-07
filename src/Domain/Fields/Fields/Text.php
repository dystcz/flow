<?php

declare(strict_types=1);

namespace Dystcz\Flow\Domain\Fields\Fields;

use Dystcz\Flow\Domain\Fields\Contracts\DataFieldContract;

class Text extends Field implements DataFieldContract
{
    public string $component = 'text';

    /**
     * Check if field value is saved.
     */
    public function isSaved(): bool
    {
        if (is_null($this->value)) {
            return false;
        }

        if ($this->value === '') {
            return false;
        }

        return true;
    }
}
