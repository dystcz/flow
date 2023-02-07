<?php

namespace Dystcz\Process\Domain\Fields\Fields;

use Dystcz\Process\Domain\Fields\Contracts\DataFieldContract;

class MultiText extends Field implements DataFieldContract
{
    public string $component = 'multi-text';
}
