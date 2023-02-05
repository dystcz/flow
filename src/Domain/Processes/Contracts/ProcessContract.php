<?php

namespace Dystcz\Process\Domain\Processes\Contracts;

use Dystcz\Process\Domain\Fields\Contracts\MediaFieldContract;

interface ProcessContract
{
    /**
     * Save media.
     *
     * @param MediaFieldContract $field
     * @return void
     */
    public function saveMedia(MediaFieldContract $field): void;
}
