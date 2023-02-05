<?php

namespace Dystcz\Process\Domain\Fields\FieldTypes;

use Dystcz\Process\Domain\Fields\Contracts\DataFieldContract;

class SelectField extends Field implements DataFieldContract
{
    public string $component = 'select';
}
