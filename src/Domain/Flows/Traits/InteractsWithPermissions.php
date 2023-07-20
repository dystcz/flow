<?php

declare(strict_types=1);

namespace Dystcz\Flow\Domain\Flows\Traits;

trait InteractsWithPermissions
{
    public static array $excludeRolesWhichCanView = [];

    public static array $excludeRolesWhichCanEdit = [];
}
