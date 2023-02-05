<?php

namespace Dystcz\Process\Domain\Fields\Fields;

use Dystcz\Process\Domain\Fields\Contracts\DataFieldContract;

class Text extends Field implements DataFieldContract
{
    public string $component = 'text';
}
