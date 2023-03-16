<?php

namespace Dystcz\Flow\Domain\Flows\Traits;

use Dystcz\Flow\Domain\Fields\Fields\Field;
use Dystcz\Flow\Domain\Flows\Http\Requests\FlowRequest;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

trait HandlesFields
{
    /**
     * Define step field.
     */
    public function fields(): array
    {
        return [];
    }

    /**
     * Define step field that will be merged before fields.
     * Useful when extending a base handler.
     */
    protected function fieldsBefore(): array
    {
        return [];
    }

    /**
     * Define step field that will be merged after fields.
     * Useful when extending a base handler.
     */
    protected function fieldsAfter(): array
    {
        return [];
    }

    /**
     * Combine fields.
     */
    protected function combineFields(): array
    {
        return array_merge(
            $this->fieldsBefore(),
            $this->fields(),
            $this->fieldsAfter()
        );
    }

    /**
     * Hydrate field values from request.
     *
     * @throws BadRequestException
     */
    protected function hydrateFieldsFromRequest(FlowRequest $request): array
    {
        return Arr::flatten(array_map(function (Field $field) use ($request) {
            // Set root field value
            $field->setValue($request->get($field->key));

            // Get selected option
            $selectedOption = Arr::first(
                $field->getOptions(),
                fn (array $option) => $option['id'] === $field->getValue(),
            );

            if (! $selectedOption) {
                return [$field];
            }

            $nestedFields = array_map(function (Field $nestedField) use ($request) {
                return $nestedField->setValue($request->get($nestedField->key));
            }, $selectedOption['fields'] ?? []);

            return array_merge([$field], $nestedFields);
        }, $this->combineFields()));
    }

    /**
     * Hydrate field values from step.
     *
     * @throws BadRequestException
     */
    public function hydrateFieldsFromStep(): array
    {
        return array_map(function (Field $field) {
            $field = $field->retrieve($this);

            // Get selected option
            $selectedOption = Arr::first(
                $field->getOptions(),
                fn (array $option) => $option['id'] === $field->getValue(),
            );

            if (! $selectedOption) {
                return $field;
            }

            $selectedOption['fields'] = array_map(function (Field $nestedField) {
                return $nestedField->retrieve($this);
            }, $selectedOption['fields'] ?? []);

            $field->setOptions(array_merge(array_filter(
                $field->getOptions(),
                fn ($option) => $option['id'] !== $selectedOption['id'],
            ), [$selectedOption]));

            return $field;
        }, $this->combineFields());
    }

    /**
     * Save field data.
     *
     * @param  FlowRequest  $data
     */
    protected function saveFields(FlowRequest $request): void
    {
        DB::transaction(function () use ($request) {
            foreach ($this->hydrateFieldsFromRequest($request) as $field) {
                $field->save($this);
            }

            $this->step()->save();
        });
    }

    /**
     * Check if all fields are saved.
     */
    public function allFieldsSaved(): bool
    {
        return $this->fieldsSaved($this->combineFields());
    }

    /**
     * Check if provided fields are saved.
     */
    public function fieldsSaved(array $fields): bool
    {
        return array_reduce($fields, function ($carry, Field $field) {
            // If field is not required and is not optional, skip
            if ($carry && ! in_array('required', $field->getRules()) && ! in_array('optional', $field->getRules())) {
                return $carry;
            }

            // Check if data is saved
            if (! $field->retrieve($this)->getValue()) {
                $carry = false;

                return $carry;
            }

            return $carry;
        }, true);
    }
}
