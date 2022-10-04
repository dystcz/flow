<?php

namespace Dystcz\Process;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Dystcz\Process\Skeleton\SkeletonClass
 */
class ProcessFacade extends Facade
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
