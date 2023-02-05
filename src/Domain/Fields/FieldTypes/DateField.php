<?php

namespace Dystcz\Process\Domain\Fields\FieldTypes;

use Dystcz\Process\Domain\Fields\Contracts\DataFieldContract;

class DateField extends Field implements DataFieldContract
{
    public string $component = 'date';
}
