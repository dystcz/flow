<?php

declare(strict_types=1);

namespace Dystcz\Flow\Domain\Fields\Traits;

use Dystcz\Flow\Domain\Fields\Fields\Field;
use Dystcz\Flow\Domain\Flows\Enums\ValidationStrategy;
use Dystcz\Flow\Domain\Flows\Facades\Flow;

trait HasRules
{
    public array $rules = [];

    public array $messages = [];

    /**
     * Set the validation rules that apply to the request.
     */
    public function rules(array $rules): Field
    {
        // Mark fields as loosely required
        if (
            // If field is required
            in_array('required', $rules)
            // If flow is set to loose validation
            && Flow::validationStrategy() === ValidationStrategy::LOOSE
            // If not overriden by strict validation
            && ! in_array(ValidationStrategy::STRICT->value, $rules)
        ) {
            $rules = array_merge($rules, [ValidationStrategy::LOOSE->value]);
        }

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
