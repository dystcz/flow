<?php

namespace Dystcz\Process\Traits;

use Dystcz\Process\Contracts\MediaFieldContract;
use Spatie\MediaLibrary\InteractsWithMedia as MediaLibraryInteractsWithMedia;

trait InteractsWithMedia
{
    use MediaLibraryInteractsWithMedia;

    /**
     * Save media.
     *
     * @param MediaFieldContract $field
     * @return void
     */
    public function saveMedia(MediaFieldContract $field): void
    {
        $this->addMedia($field->getValue())->toMediaCollection($field->getConfigValue('collection_name'));
    }
}
