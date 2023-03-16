<?php

declare(strict_types=1);

namespace Dystcz\Flow\Domain\Flows\Data;

use Dystcz\Flow\Domain\Flows\Enums\NotificationType;

class NotificationData extends DTO
{
    public function __construct(
        public NotificationType $type,
        public int $subject_id,
        public string $subject_type,
        public string $description,
        public ?string $body = null,
        public ?string $image = null,
        public array $relations = [],
        public array $meta = [],
    ) {
    }

    /**
     * Cast to array.
     */
    public function toArray(): array
    {
        return [
            'type' => $this->type->toArray(),
            'subject_type' => $this->subject_type,
            'subject_id' => $this->subject_id,
            'description' => $this->description,
            'body' => $this->body,
            'image' => $this->image,
            'relations' => $this->relations,
            'meta' => $this->meta,
        ];
    }
}
