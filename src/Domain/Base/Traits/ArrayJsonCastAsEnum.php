<?php

namespace Dystcz\Flow\Domain\Base\Traits;

trait ArrayJsonCastAsEnum
{
    use ArrayJsonCast;

    /**
     * Cast to array.
     */
    public function toArray(): array
    {
        return [
            'id' => $this->value,
            'title' => $this->label(),
        ];
    }
}
