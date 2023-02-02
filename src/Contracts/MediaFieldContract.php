<?php

namespace Dystcz\Process\Contracts;

interface MediaFieldContract
{
    /**
     * Set media collection.
     *
     * @param string $collection
     * @return self
     */
    public function setMediaCollection(string $collection): self;
}
