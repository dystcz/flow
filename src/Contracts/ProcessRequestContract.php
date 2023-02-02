<?php

namespace Dystcz\Process\Contracts;

interface ProcessRequestContract
{
    /**
     * Set handler.
     *
     * @param ProcessHandlerContract $handler
     * @return void
     */
    public function setHandler(ProcessHandlerContract $handler): void;

    /**
     * Get handler.
     *
     * @param mixed $handler
     * @return ProcessHandlerContract
     */
    public function getHandler(): ProcessHandlerContract;
}
