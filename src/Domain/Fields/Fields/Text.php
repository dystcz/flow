<?php

namespace Dystcz\Flow\Domain\Fields\Fields;

use Dystcz\Flow\Domain\Fields\Contracts\DataFieldContract;

class Text extends Field implements DataFieldContract
{
    public string $component = 'text';
}
