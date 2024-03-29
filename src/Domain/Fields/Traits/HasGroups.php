<?php

declare(strict_types=1);

namespace Dystcz\Flow\Domain\Fields\Traits;

use Dystcz\Flow\Domain\Fields\Contracts\FieldContract;
use Dystcz\Flow\Domain\Fields\Enums\FieldGroup;

trait HasGroups
{
    public array $groups = [];

    /**
     * Set field groups.
     *
     * @param  array<FieldGroup>  $groups
     */
    public function setGroups(array $groups): FieldContract
    {
        $this->groups = $groups;

        return $this;
    }

    /**
     * Get field groups.
     *
     * @return array<FieldGroup>
     */
    public function getGroups(): array
    {
        return $this->groups;
    }

    /**
     * Determine if field has group.
     */
    public function hasGroup(FieldGroup $group): bool
    {
        return in_array($group, $this->getGroups());
    }
}
