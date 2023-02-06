<?php

namespace Dystcz\Process\Domain\Fields\Handlers;

use Dystcz\Process\Domain\Fields\Contracts\FieldContract;
use Dystcz\Process\Domain\Fields\Contracts\FieldHandlerContract;
use Dystcz\Process\Domain\Processes\Contracts\ProcessHandlerContract;

class MediaFieldHandler implements FieldHandlerContract
{
    /**
     * Save field value.
     *
     * @param FieldContract $field
     * @param ProcessHandlerContract $handler
     * @return void
     */
    public function save(FieldContract $field, ProcessHandlerContract $handler): void
    {
        $handler->process()->saveMediaFieldFiles($field);
    }

    /**
     * Resolve field value.
     *
     * @param FieldContract $field
     * @param ProcessHandlerContract $handler
     * @return mixed
     */
    public function retrieve(FieldContract $field, ProcessHandlerContract $handler): mixed
    {
        $media = $handler->process()->getMedia($field->getConfigKey('collection_name', $field->getKey()));

        if ($media->isEmpty()) {
            return null;
        }

        return $media->map(fn ($media) => [
            'id' => $media->id,
            'file_name' => $media->file_name,
            'path' => "{$media->id}/{$media->file_name}",
            'url' => $media->getUrl(),
        ]);
    }
}
