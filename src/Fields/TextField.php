<?php

namespace Dystcz\Process\Fields;

use Dystcz\Process\Contracts\DataFieldContract;

class TextField extends Field implements DataFieldContract
{
    public string $component = 'text';
}
