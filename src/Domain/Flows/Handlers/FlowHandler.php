<?php

namespace Dystcz\Flow\Domain\Flows\Handlers;

use Carbon\Carbon;
use Dystcz\Flow\Domain\Flows\Contracts\FlowHandlerContract;
use Dystcz\Flow\Domain\Flows\Contracts\HasFlow;
use Dystcz\Flow\Domain\Flows\Http\Requests\FlowRequest;
use Dystcz\Flow\Domain\Flows\Models\Step;
use Dystcz\Flow\Domain\Flows\Traits\HandlesAuthorization;
use Dystcz\Flow\Domain\Flows\Traits\HandlesFields;
use Dystcz\Flow\Domain\Flows\Traits\HandlesStepEvents;
use Dystcz\Flow\Domain\Flows\Traits\HandlesValidation;
use Dystcz\Flow\Domain\Flows\Traits\InteractsWithFlowStep;
use Dystcz\Flow\Domain\Flows\Traits\InteractsWithModel;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;
use Throwable;

abstract class FlowHandler implements FlowHandlerContract
{
    use HandlesAuthorization;
    use HandlesFields;
    use HandlesValidation;
    use HandlesStepEvents;
    use InteractsWithModel;
    use InteractsWithFlowStep;

    public static string $name = 'Flow step name';

    public static string $group = 'flow';

    public static ?string $key = null;

    public static ?string $description = null;

    public static array $meta = [];

    public function __construct(public Step $step)
    {
    }

    /**
     * Handle flow step.
     *
     * @throws Throwable
     */
    public function handle(FlowRequest $request): void
    {
        $this->saveFields($request);

        // Ensures that updated model event is fired and
        // gives us the benefit of knowing when it was last saved
        $this->step->update(['saved_at' => Carbon::now()]);
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
