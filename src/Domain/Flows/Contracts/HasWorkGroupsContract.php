<?php

declare(strict_types=1);

namespace Dystcz\Flow\Domain\Flows\Contracts;

interface HasWorkGroupsContract
{
    /**
     * Get work groups.
     */
    public static function getWorkGroups(): array;

    /**
     * Get work group values.
     */
    public static function getWorkGroupValues(): array;

    /**
     * Check if step is in at least one work group.
     */
    public static function inWorkGroup(array $workGroups): bool;
}
