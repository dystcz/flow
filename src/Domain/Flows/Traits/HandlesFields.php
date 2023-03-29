<?php

declare(strict_types=1);

namespace Dystcz\Flow\Domain\Flows\Traits;

use Dystcz\Flow\Domain\Fields\Contracts\FieldContract;
use Dystcz\Flow\Domain\Fields\Fields\Field;
use Dystcz\Flow\Domain\Flows\Http\Requests\FlowRequest;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

trait HandlesFields
{
    /**
     * Define step fields.
     *
     * @return array<FieldContract>
     */
    public function fields(): array
    {
        return [];
    }

    /**
     * Define step field that will be merged before fields.
     * Useful when extending a base handler.
     *
     * @return array<FieldContract>
     */
    protected function fieldsBefore(): array
    {
        return [];
    }

    /**
     * Define step field that will be merged after fields.
     * Useful when extending a base handler.
     *
     * @return array<FieldContract>
     */
    protected function fieldsAfter(): array
    {
        return [];
    }

    /**
     * Combine fields.
     *
     * @return array<FieldContract>
     */
    protected function combineFields(): array
    {
        $fields = array_merge(
            $this->fieldsBefore(),
            $this->fields(),
            $this->fieldsAfter()
        );

        return $this->filterDisabledFields($fields);
    }

    /**
     * Filter out disabled fields.
     *
     * @return array<FieldContract>
     */
    protected function filterDisabledFields(array $fields): array
    {
        return array_filter($fields, fn (Field $field) => ! $field->isDisabled());
    }

    /**
     * Filter out readonly fields.
     *
     * @return array<FieldContract>
     */
    protected function filterReadonlyFields(array $fields): array
    {
        return array_filter($fields, fn (Field $field) => ! $field->isReadonly());
    }

    /**
     * Hydrate field values from request.
     *
     * @throws BadRequestException
     */
    protected function hydrateFieldsFromRequest(FlowRequest $request): array
    {
        $fields = $this->combineFields();

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
        }, $fields));
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
        $fields = $this->filterReadonlyFields(
            $this->hydrateFieldsFromRequest($request)
        );

        DB::transaction(function () use ($fields) {
            foreach ($fields as $field) {
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
        $fields = $this->filterReadonlyFields(
            $this->combineFields(),
        );

        return $this->fieldsSaved($fields);
    }

    /**
     * Check if provided fields are saved.
     *
     * @param  array<Field>  $fields
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

    /**
     * Fields saved by keys.
     *
     * @param  array<string>  $fieldKeys
     */
    public function fieldsSavedByKeys(array $fieldKeys): bool
    {
        return $this->fieldsSaved($this->getFieldsByKeys($fieldKeys));
    }

    /**
     * Get fields by keys.
     */
    public function getFieldsByKeys(array $fieldKeys): array
    {
        return array_values(
            array_filter(
                $this->fields(),
                fn (FieldContract $field) => in_array($field->getKey(), $fieldKeys),
            ),
        );
    }

    /**
     * Get field by key.
     */
    public function getFieldByKey(string $fieldKey): ?FieldContract
    {
        return $this->getFieldsByKeys([$fieldKey])[0] ?? null;
    }

    /**
     * Get field value by key.
     */
    public function getFieldValueByKey(string $fieldKey): mixed
    {
        return $this->getFieldByKey($fieldKey)?->retrieve($this)->getValue();
    }
}
