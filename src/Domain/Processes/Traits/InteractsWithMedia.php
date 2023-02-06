<?php

namespace Dystcz\Process\Domain\Processes\Traits;

use Dystcz\Process\Domain\Fields\Contracts\MediaFieldContract;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Database\Eloquent\MassAssignmentException;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Spatie\MediaLibrary\InteractsWithMedia as MediaLibraryInteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Exceptions\DiskDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig;

trait InteractsWithMedia
{
    use MediaLibraryInteractsWithMedia;

    /**
     * Save file to media collection.
     *
     * @param MediaFieldContract $field
     * @return void
     * @throws BindingResolutionException
     * @throws NotFoundExceptionInterface
     * @throws ContainerExceptionInterface
     * @throws FileDoesNotExist
     * @throws FileIsTooBig
     * @throws DiskDoesNotExist
     * @throws MassAssignmentException
     */
    public function saveFile(MediaFieldContract $field): void
    {
        $this
            ->addMedia($field->getValue())
            ->toMediaCollection($field->getConfigKey('collection_name'));
    }
}
