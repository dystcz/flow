<?php

namespace Dystcz\Flow\Domain\Fields\Fields;

use Dystcz\Flow\Domain\Fields\Contracts\DataFieldContract;

class EmailPreview extends Field implements DataFieldContract
{
    public string $component = 'email-preview';

    public bool $readonly = true;
}
