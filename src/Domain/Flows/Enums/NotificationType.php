<?php

namespace Dystcz\Flow\Domain\Flows\Enums;

use Dystcz\Flow\Domain\Flows\Contracts\DTOContract;

enum NotificationType: string implements DTOContract
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

    /**
     * Convert the object to its JSON representation.
     *
     * @param  int  $options
     */
    public function toJson($options = 0): string
    {
        return json_encode($this->jsonSerialize(), $options);
    }
}
