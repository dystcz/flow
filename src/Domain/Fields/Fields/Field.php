<?php

namespace Dystcz\Process\Domain\Fields\Fields;

use Dystcz\Process\Domain\Fields\Contracts\FieldContract;
use Dystcz\Process\Domain\Fields\Traits\HasComponent;
use Dystcz\Process\Domain\Fields\Traits\HasConfig;
use Dystcz\Process\Domain\Fields\Traits\HasRules;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Str;

abstract class Field implements FieldContract, Arrayable
{
    use HasComponent;
    use HasRules;
    use HasConfig;

    public function __construct(
        public string $name,
        public string $key,
        public array $options = [],
        public mixed $value = null,
    ) {
    }

    /**
     * Make attribute.
     *
     * @param string $key
     * @param array $values
     * @return static
     */
    public static function make(string $name, ?string $key = null, array $options = []): static
    {
        if (!$key) {
            $key = Str::snake($name);
        }

        return new static($name, $key, $options);
    }

    /**
     * Set value.
     *
     * @return self
     */
    public function setValue(mixed $value): self
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get value.
     *
     * @return mixed
     */
    public function getValue(): mixed
    {
        return $this->value;
    }

    /**
     * Set options.
     *
     * @return self
     */
    public function setOptions(array $options): self
    {
        $this->options = $options;

        return $this;
    }

    /**
     * Get options.
     *
     * @return array
     */
    public function getOptions(): array
    {
        return $this->options;
    }

    /**
     * To array.
     *
     * @return array
     */
    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'key' => $this->key,
            'options' => $this->getOptions(),
            'value' => $this->getValue(),
            'component' => $this->getComponent(),
            'config' => $this->getConfig(),
        ];
    }
}
