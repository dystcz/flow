<?php

namespace Dystcz\Process\Domain\Fields\Handlers;

use Dystcz\Process\Domain\Fields\Contracts\FieldContract;
use Dystcz\Process\Domain\Fields\Contracts\FieldHandlerContract;
use Dystcz\Process\Domain\Fields\Data\FieldData;
use Dystcz\Process\Domain\Processes\Contracts\ProcessHandlerContract;
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
        $process = $handler->process();

        $handler->process()->{$process::processAttributesField()}->set(
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
        $process = $handler->process();

        $data = $handler->process()->{$process::processAttributesField()}->get($field->getKey());

        if (!$data) {
            return null;
        }

        return (new FieldData(...$data))->value;
    }
}
