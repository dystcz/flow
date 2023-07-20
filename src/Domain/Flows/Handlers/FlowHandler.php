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
use Dystcz\Flow\Domain\Flows\Models\DatabaseNotification;
use Dystcz\Flow\Domain\Flows\Models\Step;
use Dystcz\Flow\Domain\Flows\Traits\HandlesAuthorization;
use Dystcz\Flow\Domain\Flows\Traits\HandlesFields;
use Dystcz\Flow\Domain\Flows\Traits\HandlesReadonlyFields;
use Dystcz\Flow\Domain\Flows\Traits\HandlesStepEvents;
use Dystcz\Flow\Domain\Flows\Traits\HandlesValidation;
use Dystcz\Flow\Domain\Flows\Traits\InteractsWithFlowStep;
use Dystcz\Flow\Domain\Flows\Traits\InteractsWithModel;
use Dystcz\Flow\Domain\Flows\Traits\InteractsWithPermissions;
use Dystcz\Flow\Domain\Flows\Traits\InteractsWithWorkGroups;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Throwable;

/**
 * @property-read Step $step
 * @property static string $name
 * @property static string $group
 * @property static string|null $key
 * @property static string|null $description
 * @property static array $meta
 * @property static array $workGroups
 * @property static array $excludeRolesWhichCanView
 * @property static array $excludeRolesWhichCanEdit
 */
abstract class FlowHandler implements FlowHandlerContract
{
    use HandlesAuthorization;
    use HandlesFields;
    use HandlesReadonlyFields;
    use HandlesStepEvents;
    use HandlesValidation;
    use InteractsWithFlowStep;
    use InteractsWithModel;
    use InteractsWithWorkGroups;
    use InteractsWithPermissions;

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

        // Clear notifications
        $this->step()->notifications->each(
            fn (DatabaseNotification $notification) => $notification->markAsRead()
        );

        $this->step()->fireFinishedEvent();
    }

    /**
     * Determine if the step should be force initialized.
     * Confition used regardless of blocking nodes.
     * Basically used for forcing initialization.
     *
     * @see Dystcz\Flow\Domain\Flows\Actions\InitializeNextSteps @getInitializableNodes()
     */
    public static function forceInitialize(HasFlow $model): bool
    {
        return false;
    }

    /**
     * Determine if the step should be initialized.
     * Confition used when deciding wether to initialize step from node graph.
     * Basically used for blocking initialization.
     *
     * @see Dystcz\Flow\Domain\Flows\Actions\InitializeNextSteps @getInitializableNodes()
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
    protected static function newHandler(Step $step = null): static
    {
        return new static($step ?? new Step);
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
