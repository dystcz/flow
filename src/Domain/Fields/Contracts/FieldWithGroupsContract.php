<?php

declare(strict_types=1);

namespace Dystcz\Flow\Domain\Fields\Contracts;

use Dystcz\Flow\Domain\Fields\Enums\FieldGroup;

interface FieldWithGroupsContract
{
    /**
     * Set field groups.
     *
     * @param  array<FieldGroup>  $groups
     */
    public function setGroups(array $groups): FieldContract;

    /**
     * Get field groups.
     *
     * @return array<FieldGroup>
     */
    public function getGroups(): array;

    /**
     * Determine if field has group.
     */
    public function hasGroup(FieldGroup $group): bool;
}
