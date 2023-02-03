<?php

namespace Dystcz\Process\Traits;

trait HasDataAttributes
{
    /**
     * Get data attribute.
     *
     * @param string $key
     * @return mixed
     */
    public function getDataAttribute(string $key): mixed
    {
        return $this->attribute_data->get($key)?->getValue();
    }
}
