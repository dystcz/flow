<?php

namespace Dystcz\Process\Domain\Fields\Handlers;

use Dystcz\Process\Domain\Fields\Contracts\FieldContract;
use Dystcz\Process\Domain\Fields\Contracts\FieldHandlerContract;
use Dystcz\Process\Domain\Fields\Data\FieldData;
use Dystcz\Process\Domain\Processes\Contracts\ProcessHandlerContract;
use Dystcz\Process\Domain\Processes\Models\Process;
use Illuminate\Support\Arr;

class DataAttributeFieldHandler implements FieldHandlerContract
{
    /**
     * Save field value.
     *
     * @param FieldContract $field
     * @param ProcessHandlerContract $handler
     * @return void
     */
    public function save(FieldContract $field, ProcessHandlerContract $handler): void
    {
        $handler->process()->{Process::processAttributesColumn()}->set(
            $field->getKey(),
            Arr::except($field->toArray(), ['options'])
        );
    }

    /**
     * Resolve field value.
     *
     * @param FieldContract $field
     * @param ProcessHandlerContract $handler
     * @return mixed
     */
    public function retrieve(FieldContract $field, ProcessHandlerContract $handler): mixed
    {
        return (new FieldData(
            ...$handler->process()->{Process::processAttributesColumn()}->get($field->getKey())
        ))->value;
    }
}
