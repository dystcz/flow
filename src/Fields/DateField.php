<?php

namespace Dystcz\Process\Fields;

use Dystcz\Process\Contracts\DataFieldContract;

class DateField extends Field implements DataFieldContract
{
    public string $component = 'date';
}
