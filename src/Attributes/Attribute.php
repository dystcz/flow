<?php

namespace Dystcz\Process\Attributes;

use Dystcz\Process\Contracts\AttributeContract;
use Illuminate\Support\Str;

abstract class Attribute implements AttributeContract
{
    public function __construct(
        public string $name,
        public string $key,
        public array $values = [],
        public array $rules = [],
        public array $messages = [],
    ) {
    }

    /**
     * Make attribute.
     *
     * @param string $key
     * @param array $values
     * @return static
     */
    public static function make(string $name, ?string $key = null, array $values = []): static
    {
        if (!$key) {
            $key = Str::snake($name);
        }

        return new static($name, $key, $values);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return self
     */
    public function rules(array $rules): self
    {
        $this->rules = $rules;

        return $this;
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return self
     */
    public function messages(array $messages): self
    {
        $this->messages = $messages;

        return $this;
    }
}
