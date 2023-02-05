<?php

namespace Dystcz\Process\Domain\Fields\Contracts;

use Dystcz\Process\Domain\Processes\Contracts\ProcessHandlerContract;

interface FieldHandlerContract
{
    /**
     * Save field value.
     *
     * @param FieldContract $field
     * @param ProcessHandlerContract $handler
     * @return void
     */
    public function save(FieldContract $field, ProcessHandlerContract $handler): void;

    /**
     * Retrieve field value.
     *
     * @param FieldContract $field
     * @param ProcessHandlerContract $handler
     * @return mixed
     */
    public function retrieve(FieldContract $field, ProcessHandlerContract $handler): mixed;
}
