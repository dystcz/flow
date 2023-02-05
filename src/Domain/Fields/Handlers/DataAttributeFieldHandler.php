<?php

namespace Dystcz\Process\Domain\Fields\Handlers;

use Dystcz\Process\Domain\Fields\Casts\FieldData;
use Dystcz\Process\Domain\Fields\Contracts\FieldContract;
use Dystcz\Process\Domain\Fields\Contracts\FieldHandlerContract;
use Dystcz\Process\Domain\Processes\Contracts\ProcessHandlerContract;

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
        // TODO: Get data storage (data storage contract)
        // Storage will save the data by its own method

        $dataAttributes = array_filter(
            $handler->process()->getCasts(),
            fn ($cast) => in_array($cast, [FieldData::class])
        );

        foreach (array_keys($dataAttributes) as $attribute) {
            $handler->process()->$attribute = $handler->process()->$attribute->merge([$field->getKey() => $field]);
        }
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
        // TODO: Get data storage (data storage contract)
        // Storage will get the data by its own method

        $dataAttributes = array_filter(
            $handler->process()->getCasts(),
            fn ($cast) => in_array($cast, [FieldData::class])
        );

        foreach (array_keys($dataAttributes) as $attribute) {
            if ($field = $handler->process()->$attribute->get($field->getKey())) {
                return $field->getValue();
            }
        }

        return null;
    }
}
