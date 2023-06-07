<?php

declare(strict_types=1);

namespace Dystcz\Flow\Domain\Flows\Traits;

use Closure;
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
     * @param  \Closure(array<FieldContract>): array  $filter
     * @return array<FieldContract>
     */
    protected function combineFields(?Closure $filter = null): array
    {
        $fields = array_merge(
            $this->fieldsBefore(),
            $this->fields(),
            $this->fieldsAfter()
        );

        $fields = $filter ? $filter($fields) : $fields;

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
     * @param  Closure(array<Field>): array  $filter
     *
     * @throws BadRequestException
     */
    public function hydrateFieldsFromStep(?Closure $filter = null): array
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
        }, $this->combineFields($filter));
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
    public function fieldsSaved(array $fields, bool $strict = false): bool
    {
        return array_reduce($fields, function ($carry, Field $field) use ($strict) {
            // If we are just checking if the step can be completed and the field is preconsidered complete
            if ($field->preconsideredComplete($strict)) {
                return $carry;
            }

            // Check if field data is saved
            if (! $this->fieldSaved($field)) {
                $carry = false;

                return $carry;
            }

            return $carry;
        }, true);
    }

    /**
     * Check if field is saved.
     */
    public function fieldSaved(Field $field): bool
    {
        return $field
            ->retrieve($this)
            ->isSaved();
    }

    /**
     * Fields saved by keys.
     *
     * @param  array<string>  $fieldKeys
     */
    public function fieldsSavedByKeys(array $fieldKeys, bool $strict = false): bool
    {
        return $this->fieldsSaved(
            fields: $this->getFieldsByKeys($fieldKeys),
            strict: $strict,
        );
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
    public function getFieldByKey(string $fieldKey): ?Field
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
