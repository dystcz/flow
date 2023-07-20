<?php

declare(strict_types=1);

namespace Dystcz\Flow\Domain\Flows\Traits;

trait InteractsWithWorkGroups
{
    public static array $workGroups = [];

    /**
     * Get work groups.
     */
    public static function getWorkGroups(): array
    {
        return static::$workGroups;
    }

    /**
     * Get work group values.
     */
    public static function getWorkGroupValues(): array
    {
        return array_map(fn ($workGroup) => $workGroup->value, static::$workGroups);
    }

    /**
     * Check if step is in at least one work group.
     *
     * @param  array<int,mixed>  $workGroups
     */
    public static function inWorkGroup(array $workGroups): bool
    {
        return array_reduce($workGroups, function ($carry, $workGroup) {
            return $carry || in_array($workGroup, static::getWorkGroups());
        }, false);
    }
}
