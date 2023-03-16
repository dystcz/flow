<?php

declare(strict_types=1);

namespace Dystcz\Flow\Domain\Flows\Casts;

use Dystcz\Flow\Domain\Flows\Data\NotificationData;
use Dystcz\Flow\Domain\Flows\Enums\NotificationType;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

class NotificationDataCast implements CastsAttributes
{
    /**
     * Cast the given value.
     *
     * @param  array<string, mixed>  $attributes
     */
    public function get($model, string $key, $value, array $attributes): NotificationData
    {
        $data = json_decode($attributes['data'], true);

        return new NotificationData(
            type: NotificationType::tryFrom($data['type']['id']) ?? NotificationType::NORMAL,
            subject_id: $data['subject_id'],
            subject_type: $data['subject_type'],
            description: $data['description'],
            body: $data['body'],
            relations: $data['relations'],
            meta: $data['meta'],
        );
    }

    /**
     * Prepare the given value for storage.
     *
     * @param  array<string, mixed>  $attributes
     * @return array<string, string>
     */
    public function set($model, string $key, $value, array $attributes): mixed
    {
        /** @var NotificationData $data */
        $data = $value;

        return [
            'data' => $data->toJson(),
        ];
    }
}
