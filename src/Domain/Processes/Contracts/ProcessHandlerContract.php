<?php

namespace Dystcz\Process\Domain\Processes\Contracts;

use Dystcz\Process\Domain\Processes\Http\Requests\ProcessRequest;
use Dystcz\Process\Domain\Processes\Models\Process;

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
    public function isComplete(): bool;

    /**
     * Get process model instance.
     *
     * @return Process
     */
    public function process(): Process;

    /**
     * Get model instance.
     *
     * @return Processable
     */
    public function model(): Processable;

    /**
     * Callback which is called when the process is created.
     *
     * @return void
     */
    public function onCreated(Process $process): void;

    /**
     * Callback which is called when the process is updated.
     *
     * @return void
     */
    public function onUpdated(Process $process): void;

    /**
     * Callback which is called when the process is finished.
     *
     * @return void
     */
    public function onFinished(Process $process): void;
}
