<?php

declare(strict_types=1);

namespace Dystcz\Flow\Domain\Base\Traits;

trait ArrayJsonCast
{
    /**
     * Cast to array.
     */
    public function toArray(): array
    {
        return [];
    }

    /**
     * Serialize to json.
     */
    public function jsonSerialize(): array
    {
        return $this->toArray();
    }

    /**
     * Convert the object to its JSON representation.
     *
     * @param  int  $options
     */
    public function toJson($options = 0): string
    {
        return json_encode($this->jsonSerialize(), $options);
    }
}
