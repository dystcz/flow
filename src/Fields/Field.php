<?php

namespace Dystcz\Process\Fields;

use Dystcz\Process\Contracts\FieldContract;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Str;

abstract class Field implements FieldContract, Arrayable
{
    public string $component = 'field';

    public array $rules = [];

    public array $messages = [];

    public array $config = [];

    public bool $saveToAttributes = true;

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
    public static function make(string $name, ?string $key = null, array $options = [], mixed $value = null): static
    {
        if (!$key) {
            $key = Str::snake($name);
        }

        return new static($name, $key, $options, $value);
    }

    /**
     * Set the validation rules that apply to the request.
     *
     * @return self
     */
    public function rules(array $rules): self
    {
        $this->rules = $rules;

        return $this;
    }

    /**
     * Get rules.
     *
     * @return array
     */
    public function getRules(): array
    {
        return $this->rules;
    }

    /**
     * Set custom messages for validator errors.
     *
     * @return self
     */
    public function messages(array $messages): self
    {
        $this->messages = $messages;

        return $this;
    }

    /**
     * Get messages.
     *
     * @return array
     */
    public function getMessages(): array
    {
        return $this->messages;
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
     * Set config.
     *
     * @return self
     */
    public function setConfig(string $key, mixed $value): self
    {
        $this->config[$key] = $value;

        return $this;
    }

    /**
     * Get config.
     *
     * @return array
     */
    public function getConfig(): array
    {
        return $this->config;
    }

    /**
     * Get component.
     *
     * @return string
     */
    public function getComponent(): string
    {
        return $this->component;
    }

    /**
     * Disable saving data to attributes.
     *
     * @return self
     */
    public function dontSaveToAttributes(): self
    {
        $this->saveToAttributes = false;

        return $this;
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
