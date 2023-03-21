<?php

declare(strict_types=1);

namespace Dystcz\Flow\Domain\Fields\Handlers;

use Dystcz\Flow\Domain\Fields\Contracts\FieldContract;
use Dystcz\Flow\Domain\Fields\Contracts\FieldHandlerContract;
use Dystcz\Flow\Domain\Flows\Contracts\FlowHandlerContract;

class MediaFieldHandler implements FieldHandlerContract
{
    /**
     * Save field value.
     */
    public function save(FieldContract $field, FlowHandlerContract $handler): void
    {
        $handler->step()->saveMediaFieldFiles($field);
    }

    /**
     * Resolve field value.
     */
    public function retrieve(FieldContract $field, FlowHandlerContract $handler): mixed
    {
        $media = $handler->step()->getMedia($field->getConfigKey('collection_name', $field->getKey()));

        if ($media->isEmpty()) {
            return null;
        }

        return $media->map(fn ($media) => [
            'id' => $media->id,
            'file_name' => $media->file_name,
            'mime_type' => $media->mime_type,
            'size' => $media->size,
            'path' => "{$media->id}/{$media->file_name}",
            'url' => $media->getUrl(),
        ]);
    }
}
