<?php

namespace Dystcz\Process\Domain\Fields\Fields;

use Closure;
use Dystcz\Process\Domain\Fields\Contracts\FieldContract;
use Dystcz\Process\Domain\Fields\Contracts\FieldHandlerContract;
use Dystcz\Process\Domain\Fields\Handlers\DataAttributeFieldHandler;
use Dystcz\Process\Domain\Fields\Traits\HasComponent;
use Dystcz\Process\Domain\Fields\Traits\HasConfig;
use Dystcz\Process\Domain\Fields\Traits\HasRules;
use Dystcz\Process\Domain\Processes\Contracts\ProcessHandlerContract;
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
     * @param string $name
     * @param string|null $key
     * @param array $values
     * @return static
     */
    public static function make(string $name, ?string $key = null, array $options = []): static
    {
        $key = $key ?? Str::snake($name);

        return new static($name, $key, $options);
    }

    /**
     * Save field value.
     *
     * @param ProcessHandlerContract $handler
     * @param null|Closure $callback
     * @return void
     */
    public function save(ProcessHandlerContract $handler, ?Closure $callback = null): void
    {
        if (!$this->getValue()) {
            return;
        }

        $callback ? $callback($this, $handler) : $this->handler()->save($this, $handler);
    }

    /**
     * Retrieve field value.
     *
     * @param ProcessHandlerContract $handler
     * @param null|Closure $callback
     * @return self
     */
    public function retrieve(ProcessHandlerContract $handler, ?Closure $callback = null): self
    {
        $value = $callback ? $callback($this, $handler) : $this->handler()->retrieve($this, $handler);

        $this->setValue($value);

        return $this;
    }

    /**
     * Get field resolver.
     *
     * @return FieldHandlerContract
     */
    public function handler(): FieldHandlerContract
    {
        return new DataAttributeFieldHandler;
    }

    /**
     * Get name.
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Get key.
     *
     * @return string
     */
    public function getKey(): string
    {
        return $this->key;
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
