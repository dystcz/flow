<?php

namespace Dystcz\Process\Domain\Fields\Fields;

use Dystcz\Process\Domain\Fields\Contracts\DataFieldContract;

class Date extends Field implements DataFieldContract
{
    public string $component = 'date';
}
