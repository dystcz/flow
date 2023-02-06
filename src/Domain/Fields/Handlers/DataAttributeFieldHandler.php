<?php

namespace Dystcz\Process\Domain\Fields\Handlers;

use Dystcz\Process\Domain\Fields\Contracts\FieldContract;
use Dystcz\Process\Domain\Fields\Contracts\FieldHandlerContract;
use Dystcz\Process\Domain\Processes\Contracts\ProcessHandlerContract;
use Dystcz\Process\Domain\Processes\Models\Process;

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
        return;
        $handler->process()->{Process::processAttributesColumn()}->set($field->getKey(), $field->getValue());
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
        return null;
        dd($handler->process()->getCasts(), $handler->process()->{Process::processAttributesColumn()});

        if ($field = $handler->process()->{Process::processAttributesColumn()}->get($field->getKey())) {
            return $field->getValue();
        }

        return null;
    }
}
