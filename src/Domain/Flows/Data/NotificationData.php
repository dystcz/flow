<?php

namespace Dystcz\Flow\Domain\Flows\Data;

use Illuminate\Contracts\Support\Arrayable;
use JsonSerializable;

class NotificationData implements Arrayable, JsonSerializable
{
    public function __construct(
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
            'subject_type' => $this->subject_type,
            'subject_id' => $this->subject_id,
            'description' => $this->description,
            'body' => $this->body,
            'image' => $this->image,
            'relations' => $this->relations,
            'meta' => $this->meta,
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
