<?php

declare(strict_types=1);

namespace Dystcz\Flow\Domain\Flows\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static Dystcz\Flow\Domain\Flows\Enums\ValidationStrategy validationStrategy()
 *
 * @see \Dystcz\Flow\Domain\Flows\Flow
 */
class Flow extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'flow';
    }
}
