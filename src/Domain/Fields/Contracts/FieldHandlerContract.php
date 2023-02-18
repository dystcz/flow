<?php

namespace Dystcz\Flow\Domain\Fields\Contracts;

use Dystcz\Flow\Domain\Flows\Contracts\FlowHandlerContract;

interface FieldHandlerContract
{
    /**
     * Save field value.
     */
    public function save(FieldContract $field, FlowHandlerContract $handler): void;

    /**
     * Retrieve field value.
     */
    public function retrieve(FieldContract $field, FlowHandlerContract $handler): mixed;
}
