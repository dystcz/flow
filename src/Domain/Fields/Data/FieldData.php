<?php

namespace Dystcz\Process\Domain\Fields\Data;

use Dystcz\Process\Domain\Fields\Contracts\FieldContract;

class FieldData
{
    public function __construct(
        public string $name,
        public string $key,
        public string $field_type,
        public mixed $value = null,
        public array $config = [],
        public array $options = [],
        public ?string $component = null,
    ) {
    }

    /**
     * Create a new field instance.
     *
     * @return FieldContract
     */
    public function toField(): FieldContract
    {
        $field = new $this->field_type(
            $this->name,
            $this->key,
            $this->options,
            $this->value,
        );

        if (!empty($this->config)) {
            $field->setConfig($this->config);
        }

        if (!empty($this->component)) {
            $field->setComponent($this->component);
        }

        return $field;
    }
}
