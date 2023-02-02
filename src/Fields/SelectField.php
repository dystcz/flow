<?php

namespace Dystcz\Process\Fields;

use Dystcz\Process\Contracts\DataFieldContract;

class SelectField extends Field implements DataFieldContract
{
    public string $component = 'select';
}
