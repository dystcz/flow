<?php

declare(strict_types=1);

namespace Dystcz\Flow\Domain\Fields\Traits;

use Dystcz\Flow\Domain\Fields\Fields\Field;

trait HasRules
{
    public array $rules = [];

    public array $messages = [];

    /**
     * Set the validation rules that apply to the request.
     */
    public function rules(array $rules): Field
    {
        $this->rules = $rules;

        return $this;
    }

    /**
     * Get validation rules.
     */
    public function getRules(): array
    {
        return $this->rules;
    }

    /**
     * Set custom messages for validator errors.
     */
    public function messages(array $messages): Field
    {
        $this->messages = $messages;

        return $this;
    }

    /**
     * Get custom messages.
     */
    public function getMessages(): array
    {
        return $this->messages;
    }
}
