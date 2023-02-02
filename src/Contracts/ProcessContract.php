<?php

namespace Dystcz\Process\Contracts;

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
