<?php

namespace Dystcz\Process\Domain\Processes\Traits;

use Dystcz\Process\Domain\Fields\Fields\Field;
use Dystcz\Process\Domain\Processes\Http\Requests\ProcessRequest;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

trait HandlesFields
{
    /**
     * Define process field.
     *
     * @return array
     */
    public function fields(): array
    {
        return [];
    }

    /**
     * Hydrate field values from request.
     *
     * @param ProcessRequest $request
     * @return array
     * @throws BadRequestException
     */
    protected function hydrateFieldsFromRequest(ProcessRequest $request): array
    {
        return array_map(
            fn (Field $field) => $field->setValue($request->get($field->key)),
            $this->fields()
        );
    }

    /**
     * Hydrate field values from process.
     *
     * @param ProcessRequest $request
     * @return array
     * @throws BadRequestException
     */
    public function hydrateFieldsFromProcess(ProcessRequest $request): array
    {
        return array_map(
            fn (Field $field) => $field->retrieve($this),
            $this->fields()
        );
    }

    /**
     * Save field data.
     *
     * @param ProcessRequest $data
     * @return void
     */
    protected function saveFields(ProcessRequest $request): void
    {
        DB::transaction(function () use ($request) {
            foreach ($this->hydrateFieldsFromRequest($request) as $field) {
                $field->save($this);
            }

            $this->process()->save();
        });
    }

    /**
     * Check if all fields are saved.
     *
     * @return bool
     */
    public function allFieldsSaved(): bool
    {
        return array_reduce($this->fields(), function ($carry, $field) {
            // If field is not required, skip
            if ($carry && !in_array('required', $field->getRules())) {
                return $carry;
            }

            // Check if data is filled
            if (!$field->retrieve()->getValue()) {
                $carry = false;

                return $carry;
            }

            return $carry;
        }, true);
    }
}
