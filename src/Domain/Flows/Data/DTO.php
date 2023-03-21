<?php

declare(strict_types=1);

namespace Dystcz\Flow\Domain\Flows\Data;

use Dystcz\Flow\Domain\Flows\Contracts\DTOContract;

abstract class DTO implements DTOContract
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
    public function jsonSerialize(): mixed
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
