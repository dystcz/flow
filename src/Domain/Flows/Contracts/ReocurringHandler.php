<?php

declare(strict_types=1);

namespace Dystcz\Flow\Domain\Flows\Contracts;

/**
 * Some flow steps can be invoked multiple times.
 * Implementing this interface won't prevent initializing multiple steps with this handler.
 */
interface ReocurringHandler
{
}
