<?php

declare(strict_types=1);

namespace Dystcz\Flow\Domain\Flows\Traits;

use Dystcz\Flow\Domain\Fields\Contracts\MediaFieldContract;
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
     * @throws BindingResolutionException
     * @throws NotFoundExceptionInterface
     * @throws ContainerExceptionInterface
     * @throws FileDoesNotExist
     * @throws FileIsTooBig
     * @throws DiskDoesNotExist
     * @throws MassAssignmentException
     */
    public function saveMediaFieldFiles(MediaFieldContract $field): void
    {
        $this
            ->addMedia($field->getValue())
            ->toMediaCollection($field->getConfigKey('collection_name'));
    }
}
