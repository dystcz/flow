<?php

namespace Dystcz\Flow\Domain\Fields\Traits;

trait HasRules
{
    public array $rules = [];

    public array $messages = [];

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
     * Get validation rules.
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
     * Get custom messages.
     *
     * @return array
     */
    public function getMessages(): array
    {
        return $this->messages;
    }
}
