<?php

declare(strict_types=1);

namespace Dystcz\Flow\Domain\Fields\Enums;

use Dystcz\Flow\Domain\Base\Traits\ArrayJsonCast;
use Dystcz\Flow\Domain\Flows\Contracts\EnumContract;

enum FieldGroup: string implements EnumContract
{
    use ArrayJsonCast;

    case DATA = 'data';
    case MISC = 'misc';
    case EMAIL_TEMPLATES = 'email-templates';

    /**
     * Get label.
     */
    public function label(): string
    {
        return __('flow.fields.groups.'.$this->value);
    }

    /**
     * Get the instance as an array.
     */
    public function toArray(): array
    {
        return [
            'id' => $this->value,
            'title' => $this->label(),
        ];
    }
}
