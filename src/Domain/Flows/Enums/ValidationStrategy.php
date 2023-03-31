<?php

declare(strict_types=1);

namespace Dystcz\Flow\Domain\Flows\Enums;

enum ValidationStrategy: string
{
    /**
     * All required fields must be filled in order to **save** the step.
     */
    case STRICT = 'strict';

    /**
     * All required fields must be filled in order to **complete** the step.
     * Step can be saved even if some required fields are not filled.
     */
    case LOOSE = 'loose';
}
