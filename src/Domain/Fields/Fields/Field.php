<?php

namespace Dystcz\Flow\Domain\Fields\Fields;

use Closure;
use Dystcz\Flow\Domain\Fields\Contracts\FieldContract;
use Dystcz\Flow\Domain\Fields\Contracts\FieldHandlerContract;
use Dystcz\Flow\Domain\Fields\Data\FieldData;
use Dystcz\Flow\Domain\Fields\Handlers\DataAttributeFieldHandler;
use Dystcz\Flow\Domain\Fields\Traits\HasComponent;
use Dystcz\Flow\Domain\Fields\Traits\HasConfig;
use Dystcz\Flow\Domain\Fields\Traits\HasRules;
use Dystcz\Flow\Domain\Flows\Contracts\FlowHandlerContract;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Str;
use JsonSerializable;

abstract class Field implements FieldContract, Arrayable, JsonSerializable
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
     * @param  array  $values
     */
    public static function make(string $name, ?string $key = null, array $options = []): static
    {
        $key = $key ?? Str::snake($name);

        return new static($name, $key, $options);
    }

    /**
     * Save field value.
     */
    public function save(FlowHandlerContract $handler, ?Closure $callback = null): void
    {
        if (! $this->getValue()) {
            return;
        }

        $callback ? $callback($this, $handler) : $this->handler()->save($this, $handler);
    }

    /**
     * Retrieve field value.
     */
    public function retrieve(FlowHandlerContract $handler, ?Closure $callback = null): self
    {
        $value = $callback ? $callback($this, $handler) : $this->handler()->retrieve($this, $handler);

        $this->setValue($value);

        return $this;
    }

    /**
     * Get field resolver.
     */
    public function handler(): FieldHandlerContract
    {
        return new DataAttributeFieldHandler;
    }

    /**
     * Get name.
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Get key.
     */
    public function getKey(): string
    {
        return $this->key;
    }

    /**
     * Set value.
     */
    public function setValue(mixed $value): self
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get value.
     */
    public function getValue(): mixed
    {
        return $this->value;
    }

    /**
     * Set options.
     */
    public function setOptions(array $options): self
    {
        $this->options = $options;

        return $this;
    }

    /**
     * Get options.
     */
    public function getOptions(): array
    {
        return $this->options;
    }

    /**
     * To array.
     */
    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'key' => $this->key,
            'value' => $this->getValue(),
            'config' => $this->getConfig(),
            'field_type' => get_class($this),
            'options' => $this->getOptions(),
            'component' => $this->getComponent(),
        ];
    }

    /**
     * Cast to field data.
     */
    public function toFieldData(): FieldData
    {
        return new FieldData(...$this->toArray());
    }

    /**
     * Serialize to json.
     */
    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
