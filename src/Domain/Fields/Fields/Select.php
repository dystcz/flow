<?php

namespace Dystcz\Process\Domain\Fields\Fields;

use Dystcz\Process\Domain\Fields\Contracts\DataFieldContract;

class Select extends Field implements DataFieldContract
{
    public string $component = 'select';
}
