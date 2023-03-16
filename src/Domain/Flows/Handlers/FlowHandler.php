<?php

declare(strict_types=1);

namespace Dystcz\Flow\Domain\Flows\Handlers;

use Carbon\Carbon;
use Dystcz\Flow\Domain\Fields\Fields\Boolean;
use Dystcz\Flow\Domain\Fields\Fields\Field;
use Dystcz\Flow\Domain\Flows\Actions\InitializeNextSteps;
use Dystcz\Flow\Domain\Flows\Contracts\FlowHandlerContract;
use Dystcz\Flow\Domain\Flows\Contracts\HasFlow;
use Dystcz\Flow\Domain\Flows\Enums\StepStatus;
use Dystcz\Flow\Domain\Flows\Http\Requests\FlowRequest;
use Dystcz\Flow\Domain\Flows\Models\Step;
use Dystcz\Flow\Domain\Flows\Traits\HandlesAuthorization;
use Dystcz\Flow\Domain\Flows\Traits\HandlesFields;
use Dystcz\Flow\Domain\Flows\Traits\HandlesReadonlyFields;
use Dystcz\Flow\Domain\Flows\Traits\HandlesStepEvents;
use Dystcz\Flow\Domain\Flows\Traits\HandlesValidation;
use Dystcz\Flow\Domain\Flows\Traits\InteractsWithFlowStep;
use Dystcz\Flow\Domain\Flows\Traits\InteractsWithModel;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Throwable;

abstract class FlowHandler implements FlowHandlerContract
{
    use HandlesAuthorization;
    use HandlesFields;
    use HandlesReadonlyFields;
    use HandlesStepEvents;
    use HandlesValidation;
    use InteractsWithFlowStep;
    use InteractsWithModel;

    public static string $name = 'Flow step name';

    public static string $group = 'flow';

    public static ?string $key = null;

    public static ?string $description = null;

    public static array $meta = [];

    protected InitializeNextSteps $initializeNextSteps;

    public function __construct(public Step $step)
    {
        $this->initializeNextSteps = new InitializeNextSteps($this->step());
    }

    /**
     * Handle flow step.
     *
     * @throws Throwable
     */
    public function handle(FlowRequest $request): void
    {
        // Save all fields. Some of them can have custom save callbacks.
        $this->saveFields($request);

        // Refresh step model after saving fields.
        $this->step()->refresh();

        // If everything is complete, finish the step.
        if ($this->isComplete() && ! $this->step->isFinished()) {
            $this->finish();
        }
    }

    /**
     * Force finish the step.
     */
    // WARNING: Experimental for now
    // TODO: Handle force finish validation and test it thoroughly
    protected function forceFinish(): bool
    {
        $forceFinishField = Arr::first(
            $this->combineFields(),
            fn (Field $field) => ($field->getKey() === 'force_finish') && ($field instanceof Boolean)
        );

        return $forceFinishField?->getValue() === true;
    }

    /**
     * Finish flow step.
     */
    public function finish(): void
    {
        // If the finishing event returns false, cancel the
        // finish operation so it can be cancelled by validation for example.
        if ($this->step()->fireFinishingEvent() === false) {
            return;
        }

        // User defined callback
        $this->onFinished($this->step());

        // Mark as finished and initialize next steps.
        DB::transaction(function () {
            $this->step()->update([
                'finished_at' => Carbon::now(),
                'status' => StepStatus::FINISHED,
            ]);

            $this->step()->load([
                'model',
                'model.steps',
            ]);

            $this->initializeNextSteps->handle();
        });

        $this->step()->fireFinishedEvent();
    }

    /**
     * Determine if the step should be initialized.
     */
    public static function shouldInitialize(HasFlow $model): bool
    {
        return true;
    }

    /**
     * Determine if the step is finished.
     * List all conditions necessary here.
     */
    public function isComplete(): bool
    {
        if (Config::get('flow.testing')) {
            return true;
        }

        return $this->allFieldsSaved();
    }

    /**
     * Return a fresh handler instance.
     */
    protected static function newHandler(?Step $step = null): static
    {
        return new static($step ?? new Step());
    }

    /**
     * Get flow step name.
     */
    public static function name(): string
    {
        return self::newHandler()::$name;
    }

    /**
     * Get flow step group.
     */
    public static function group(): string
    {
        return self::newHandler()::$group;
    }

    /**
     * Get flow step key.
     */
    public static function key(): string
    {
        return self::newHandler()::$key ?? Str::slug(self::newHandler()::name());
    }

    /**
     * Get flow step description.
     *
     * @return ?string
     */
    public static function description(): ?string
    {
        return self::newHandler()::$description;
    }

    /**
     * Get flow meta attributes.
     *
     * @return string
     */
    public static function meta(): array
    {
        return self::newHandler()::$meta;
    }
}
