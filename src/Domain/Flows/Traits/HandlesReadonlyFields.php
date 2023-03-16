<?php

declare(strict_types=1);

namespace Dystcz\Flow\Domain\Flows\Traits;

use Dystcz\Flow\Domain\Fields\Fields\Field;

trait HandlesReadonlyFields
{
    /**
     * Define step readonly fields.
     */
    public function readonlyFields(): array
    {
        return [];
    }

    /**
     * Hydrate readonly fields.
     */
    public function hydrateReadonlyFields(): array
    {
        return array_map(function (Field $field) {
            return $field->retrieve($this);
        }, $this->markFieldsReadonly());
    }

    /**
     * Mark readonly fields.
     */
    protected function markFieldsReadonly(): array
    {
        return array_map(function (Field $field) {
            return $field->setReadonly();
        }, $this->readonlyFields());
    }
}
