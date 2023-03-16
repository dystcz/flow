<?php

namespace Dystcz\Flow\Domain\Flows\Enums;

use Dystcz\Flow\Domain\Base\Traits\ArrayJsonCastAsEnum;
use Dystcz\Flow\Domain\Flows\Contracts\EnumContract;

enum NotificationType: string implements EnumContract
{
    use ArrayJsonCastAsEnum;

    case NORMAL = 'normal';
    case WARNING = 'warning';
    case ERROR = 'error';

    /**
     * Get notification type label.
     */
    public function label(): string
    {
        return match ($this) {
            self::NORMAL => __('enums.notifications.type.normal'),
            self::WARNING => __('enums.notifications.type.warning'),
            self::ERROR => __('enums.notifications.type.error'),
        };
    }

    /**
     * Get notification type color.
     */
    public function color(): string
    {
        return match ($this) {
            self::NORMAL => 'blue-200',
            self::WARNING => 'orange-200',
            self::ERROR => 'red-200',
        };
    }

    /**
     * Cast to array.
     */
    public function toArray(): array
    {
        return [
            'id' => $this->value,
            'title' => $this->label(),
            'color' => $this->color(),
        ];
    }
}
