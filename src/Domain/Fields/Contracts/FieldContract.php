<?php

declare(strict_types=1);

namespace Dystcz\Flow\Domain\Fields\Contracts;

use Dystcz\Flow\Domain\Flows\Contracts\FlowHandlerContract;

interface FieldContract extends DisabledFieldContract, ReadonlyFieldContract, FieldWithHelpContract, FieldWithConfigContract, FieldWithComponentContract, FieldWithGroupsContract
{
    /**
     * Get field handler.
     */
    public function handler(): FieldHandlerContract;

    /**
     * Save field value.
     */
    public function save(FlowHandlerContract $handler): void;

    /**
     * Check if value is saved.
     */
    public function isSaved(): bool;

    /**
     * Retrieve field value.
     */
    public function retrieve(FlowHandlerContract $handler): self;

    /**
     * Get name.
     */
    public function getName(): string;

    /**
     * Get key.
     */
    public function getKey(): string;

    /**
     * Set value.
     */
    public function setValue(mixed $value): self;

    /**
     * Get value.
     */
    public function getValue(): mixed;

    /**
     * Set formatted value.
     */
    public function setFormattedValue(mixed $value): self;

    /**
     * Get formatted value.
     */
    public function getFormattedValue(): mixed;

    /**
     * Set options.
     */
    public function setOptions(array $options): self;

    /**
     * Get options.
     */
    public function getOptions(): array;

    /**
     * Set the validation rules that apply to the request.
     */
    public function rules(array $rules): self;

    /**
     * Get validation rules.
     */
    public function getRules(): array;

    /**
     * Check if field is considered complete without checking if the value was saved.
     */
    public function preconsideredComplete(bool $strict = false): bool;

    /**
     * Set custom messages for validator errors.
     */
    public function messages(array $messages): self;

    /**
     * Get custom messages.
     */
    public function getMessages(): array;

    /**
     * Get config value.
     */
    public function getConfigKey(string $key, mixed $default = null): mixed;

    /**
     * To array.
     */
    public function toArray(): array;
}
