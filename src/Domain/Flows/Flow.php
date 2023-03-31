<?php

declare(strict_types=1);

namespace Dystcz\Flow\Domain\Flows;

use Dystcz\Flow\Domain\Flows\Enums\ValidationStrategy;
use Illuminate\Support\Facades\Config;
use InvalidArgumentException;

class Flow
{
    /**
     * Get validation strategy.
     *
     * @throws InvalidArgumentException
     */
    public function validationStrategy(): ValidationStrategy
    {
        $strategy = Config::get('flow.steps.validation_strategy');

        if ($strategy instanceof ValidationStrategy) {
            return $strategy;
        }

        $strategy = ValidationStrategy::from($strategy);

        return $strategy;
    }
}
