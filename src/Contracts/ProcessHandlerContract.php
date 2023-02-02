<?php

namespace Dystcz\Process\Contracts;

use Dystcz\Process\Models\Process;

interface ProcessHandlerContract
{
    /**
     * Handle the process.
     *
     * @return void
     */
    public function handle(): void;

    /**
     * Define process fields.
     *
     * @return void
     */
    public function fields(): array;

    /**
     * Get process model instance.
     *
     * @return Process
     */
    public function getProcess(): Process;

    /**
     * Get model instance.
     *
     * @return Processable
     */
    public function getModel(): Processable;
}
