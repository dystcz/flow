<?php

namespace Dystcz\Flow\Domain\Flows\Traits;

use Dystcz\Flow\Domain\Fields\Fields\Field;
use Dystcz\Flow\Domain\Flows\Http\Requests\FlowRequest;
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
     * Hydrate field values from request.
     *
     *
     * @throws BadRequestException
     */
    protected function hydrateFieldsFromRequest(FlowRequest $request): array
    {
        return array_map(
            fn (Field $field) => $field->setValue($request->get($field->key)),
            $this->fields()
        );
    }

    /**
     * Hydrate field values from step.
     *
     * @throws BadRequestException
     */
    public function hydrateFieldsFromStep(): array
    {
        return array_map(
            fn (Field $field) => $field->retrieve($this),
            $this->fields()
        );
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
        return array_reduce($this->fields(), function ($carry, Field $field) {
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
