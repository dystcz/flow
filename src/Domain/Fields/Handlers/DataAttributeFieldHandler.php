<?php

namespace Dystcz\Flow\Domain\Fields\Handlers;

use Dystcz\Flow\Domain\Fields\Contracts\FieldContract;
use Dystcz\Flow\Domain\Fields\Contracts\FieldHandlerContract;
use Dystcz\Flow\Domain\Fields\Data\FieldData;
use Dystcz\Flow\Domain\Flows\Contracts\FlowHandlerContract;
use Illuminate\Support\Arr;

class DataAttributeFieldHandler implements FieldHandlerContract
{
    /**
     * Save field value.
     */
    public function save(FieldContract $field, FlowHandlerContract $handler): void
    {
        $step = $handler->step();

        $handler->step()->{$step::stepAttributesField()}->set(
            $field->getKey(),
            Arr::except($field->toArray(), ['options'])
        );
    }

    /**
     * Resolve field value.
     */
    public function retrieve(FieldContract $field, FlowHandlerContract $handler): mixed
    {
        $step = $handler->step();

        $data = $step->{$step::stepAttributesField()}->get($field->getKey());

        // If default value is set on field, return it
        if (! $data && $field->getValue()) {
            return $field->getValue();
        }

        if (! $data) {
            return null;
        }

        return (new FieldData(...$data))->value;
    }
}
