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
    // public function handle(): void;

    /**
     * Define process fields.
     *
     * @return array
     */
    public function fields(): array;

    /**
     * Determine if the process is finished.
     *
     * @return bool
     */
    public function isFinished(): bool;

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
