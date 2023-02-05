<?php

namespace Dystcz\Process\Domain\Processes\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Dystcz\Process\Skeleton\SkeletonClass
 */
class Process extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'process';
    }
}
