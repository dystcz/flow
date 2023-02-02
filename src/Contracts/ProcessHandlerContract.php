<?php

namespace Dystcz\Process\Contracts;

use Dystcz\Process\Http\Requests\ProcessRequest;
use Dystcz\Process\Models\Process;

interface ProcessHandlerContract
{
    /**
     * Handle the process.
     *
     * @return void
     */
    public function handle(ProcessRequest $request): void;

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

    /**
     * Callback which is called when the process is created.
     *
     * @return void
     */
    public function onCreate(Process $process): void;

    /**
     * Callback which is called when the process is updated.
     *
     * @return void
     */
    public function onUpdate(Process $process): void;

    /**
     * Callback which is called when the process is finished.
     *
     * @return void
     */
    public function onFinished(Process $process): void;
}
