<?php

namespace Dystcz\Flow\Domain\Flows\Enums;

use Dystcz\Flow\Domain\Flows\Contracts\StatusContract;
use Illuminate\Contracts\Support\Arrayable;
use JsonSerializable;

enum NotificationType: string implements StatusContract, Arrayable, JsonSerializable
{
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
            self::NORMAL => 'bg-blue-200',
            self::WARNING => 'bg-orange-200',
            self::ERROR => 'bg-red-200',
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

    /**
     * Serialize to json.
     */
    public function jsonSerialize(): mixed
    {
        return $this->toArray();
    }
}
