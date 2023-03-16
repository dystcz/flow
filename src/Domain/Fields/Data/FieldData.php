<?php

namespace Dystcz\Flow\Domain\Fields\Data;

use Dystcz\Flow\Domain\Fields\Contracts\FieldContract;
use Dystcz\Flow\Domain\Fields\Enums\FieldGroup;

class FieldData
{
    public function __construct(
        public string $name,
        public string $key,
        public string $field_type,
        public mixed $value = null,
        public array $config = [],
        public array $options = [],
        /** @var array<FieldGroup> */
        public array $groups = [],
        public ?string $component = null,
        public bool $readonly = false,
        public ?string $help = null,
    ) {
    }

    /**
     * Create a new field instance.
     */
    public function toField(): FieldContract
    {
        /** @var FieldContract $field */
        $field = new $this->field_type(
            $this->name,
            $this->key,
            $this->options,
            $this->value,
        );

        if (! empty($this->config)) {
            $field->setConfig($this->config);
        }

        if (! empty($this->component)) {
            $field->setComponent($this->component);
        }

        $field->setReadonly($this->readonly);
        $field->setHelp($this->help);
        $field->setGroups($this->groups);

        return $field;
    }
}
