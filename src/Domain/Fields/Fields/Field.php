<?php

declare(strict_types=1);

namespace Dystcz\Flow\Domain\Fields\Fields;

use Closure;
use Dystcz\Flow\Domain\Base\Traits\ArrayJsonCast;
use Dystcz\Flow\Domain\Fields\Contracts\FieldContract;
use Dystcz\Flow\Domain\Fields\Contracts\FieldHandlerContract;
use Dystcz\Flow\Domain\Fields\Data\FieldData;
use Dystcz\Flow\Domain\Fields\Enums\FieldKeysEnumContract;
use Dystcz\Flow\Domain\Fields\Handlers\DataAttributeFieldHandler;
use Dystcz\Flow\Domain\Fields\Traits\CanBeDisabled;
use Dystcz\Flow\Domain\Fields\Traits\CanBeReadonly;
use Dystcz\Flow\Domain\Fields\Traits\HasCallbacks;
use Dystcz\Flow\Domain\Fields\Traits\HasComponent;
use Dystcz\Flow\Domain\Fields\Traits\HasConfig;
use Dystcz\Flow\Domain\Fields\Traits\HasGroups;
use Dystcz\Flow\Domain\Fields\Traits\HasHelp;
use Dystcz\Flow\Domain\Fields\Traits\HasRules;
use Dystcz\Flow\Domain\Flows\Contracts\FlowHandlerContract;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Support\Str;
use JsonSerializable;

abstract class Field implements FieldContract, Arrayable, JsonSerializable, Jsonable
{
    use ArrayJsonCast;
    use CanBeDisabled;
    use CanBeReadonly;
    use HasCallbacks;
    use HasComponent;
    use HasConfig;
    use HasGroups;
    use HasHelp;
    use HasRules;

    public function __construct(
        public string $name,
        public string $key,
        public array $options = [],
        public mixed $value = null,
        public mixed $formattedValue = null,
    ) {
    }

    /**
     * Make attribute.
     *
     * @param  array  $values
     */
    public static function make(string $name, string|FieldKeysEnumContract|null $key = null, array $options = []): static
    {
        if ($key instanceof FieldKeysEnumContract) {
            $key = $key->value;
        }

        $key = $key ?? Str::snake(Str::slug($name));

        return new static($name, $key, $options);
    }

    /**
     * Save field value.
     */
    public function save(FlowHandlerContract $handler): void
    {
        $callback = $this->saveCallback;

        $callback ? $callback($this, $handler) : $this->handler()->save($this, $handler);
    }

    /**
     * Check if value is saved.
     */
    public function isSaved(): bool
    {
        return ! is_null($this->getValue()) ? true : false;
    }

    /**
     * Retrieve field value.
     */
    public function retrieve(FlowHandlerContract $handler): self
    {
        $callback = $this->retrieveCallback;

        $value = $callback ? $callback($this, $handler) : $this->handler()->retrieve($this, $handler);

        $this->setValue($value);

        if ($format = $this->formatCallback) {
            $this->setFormattedValue($format($this, $handler));
        }

        return $this;
    }

    /**
     * Retrieve placeholder field value.
     * If value is set, set it instead of the placeholder.
     */
    public function retrievePlaceholder(FlowHandlerContract $handler, Closure $callback): self
    {
        $value = $this->handler()->retrieve($this, $handler) ?? $callback($this, $handler);

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
        if ($value instanceof Closure) {
            $this->value = $value($this);

            return $this;
        }

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
     * Set formatted value.
     */
    public function setFormattedValue(mixed $value): self
    {
        if ($value instanceof Closure) {
            $this->formattedValue = $value($this);

            return $this;
        }

        $this->formattedValue = $value;

        return $this;
    }

    /**
     * Get value.
     */
    public function getFormattedValue(): mixed
    {
        return $this->formattedValue;
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
            'formatted_value' => $this->getFormattedValue(),
            'config' => $this->getConfig(),
            'field_type' => get_class($this),
            'options' => $this->getOptions(),
            'component' => $this->getComponent(),
            'rules' => $this->getRules(),
            'groups' => $this->getGroups(),
            'readonly' => $this->isReadonly(),
            'help' => $this->getHelp(),
        ];
    }

    /**
     * Cast to field data.
     */
    public function toFieldData(): FieldData
    {
        return new FieldData(...$this->toArray());
    }
}
