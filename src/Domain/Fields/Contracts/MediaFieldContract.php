<?php

namespace Dystcz\Flow\Domain\Fields\Contracts;

interface MediaFieldContract extends FieldContract
{
    /**
     * Set media collection.
     */
    public function setMediaCollection(string $collection): self;
}
