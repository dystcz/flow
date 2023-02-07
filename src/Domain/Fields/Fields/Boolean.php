<?php

namespace Dystcz\Process\Domain\Fields\Fields;

use Dystcz\Process\Domain\Fields\Contracts\DataFieldContract;

class Boolean extends Field implements DataFieldContract
{
    public string $component = 'boolean';
}
