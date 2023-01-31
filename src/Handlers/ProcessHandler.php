<?php

namespace Dystcz\Process\Handlers;

use Dystcz\Process\Collections\ProcessCollection;
use Dystcz\Process\Contracts\ProcessHandlerContract;
use Dystcz\Process\Models\Process;
use Dystcz\Process\Models\ProcessNode;
use Dystcz\Process\Models\ProcessTemplate;
use Dystcz\Process\Notifications\ProcessNotification;
use Illuminate\Support\Collection;
use Lorisleiva\Actions\Concerns\AsAction;

abstract class ProcessHandler implements ProcessHandlerContract
{
    use AsAction;

    protected ProcessNotification $notification;

    protected ProcessNode $node;

    protected ProcessTemplate $template;

    /**
     * Define process fields.
     *
     * @return array
     */
    public function fields(): array
    {
        return [];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return Collection::make($this->fields())->mapWithKeys(
            fn ($field) => [$field->key => $field->rules]
        )->toArray();
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages(): array
    {
        return Collection::make($this->fields())->mapWithKeys(
            fn ($field) => Collection::make($field->messages)->mapWithKeys(
                fn ($message, $rule) => ["{$field->key}.{$rule}" => $message]
            )->toArray()
        )->toArray();
    }

    /**
     * Check that all blocking processes are finished.
     *
     * @return bool
     */
    public function initialisable(): bool
    {
        // If there are no unfinished blocking processes, return true.
        return $this->getUnfinishedBlockingProcesses()->isEmpty();
    }

    /**
     * Get all blocking processes.
     *
     * @return ProcessCollection
     */
    public function getBlockingProcesses(): ProcessCollection
    {
        $blocking = $this->process->node->blockingNodes;

        // Get all processes in the tree
        // Filter out those, that are blocking

        return $blocking;
    }

    /**
     * Get all unfinished blocking processes.
     *
     * @return ProcessCollection
     */
    public function getUnfinishedBlockingProcesses(): ProcessCollection
    {
        return $this->getBlockingProcesses()->filter(
            fn ($process) => !$process->isFinished()
        );
    }

    /**
     * Get collection of prev processes.
     *
     * @return ProcessCollection<Process>
     */
    public function prevProcesses(): ProcessCollection
    {
        // TODO: Implement retrieval of previous processes from process node tree.
        return new ProcessCollection();
    }

    /**
     * Get collection of next processes.
     *
     * @return ProcessCollection<Process>
     */
    public function nextProcesses(): ProcessCollection
    {
        // TODO: Implement retrieval of next processes from process node tree.
        return new ProcessCollection();
    }

    /**
     * Handle the Process "initialized" event.
     *
     * @param  Process  $process
     * @return void
     */
    protected function initialized(Process $process): void
    {
        //
    }

    /**
     * Handle the Process "updated" event.
     *
     * @param  Process  $process
     * @return void
     */
    protected function updated(Process $process): void
    {
        //
    }

    /**
     * Handle the Process "closed" event.
     *
     * @param  Process  $process
     * @return void
     */
    protected function closed(Process $process): void
    {
        //
    }

    /**
     * Handle the Process "reopened" event.
     *
     * @param  Process  $process
     * @return void
     */
    protected function reopened(Process $process): void
    {
        //
    }

    /**
     * Handle the Process "finished" event.
     *
     * @param  Process  $process
     * @return void
     */
    protected function finished(Process $process): void
    {
        //
    }
}
