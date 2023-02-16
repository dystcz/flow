<?php

namespace Dystcz\Process\Domain\Processes\Handlers;

use Carbon\Carbon;
use Dystcz\Process\Domain\Processes\Contracts\Processable;
use Dystcz\Process\Domain\Processes\Contracts\ProcessHandlerContract;
use Dystcz\Process\Domain\Processes\Http\Requests\ProcessRequest;
use Dystcz\Process\Domain\Processes\Models\Process;
use Dystcz\Process\Domain\Processes\Traits\HandlesAuthorization;
use Dystcz\Process\Domain\Processes\Traits\HandlesFields;
use Dystcz\Process\Domain\Processes\Traits\HandlesProcessEvents;
use Dystcz\Process\Domain\Processes\Traits\HandlesValidation;
use Dystcz\Process\Domain\Processes\Traits\InteractsWithModel;
use Dystcz\Process\Domain\Processes\Traits\InteractsWithProcess;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;
use Throwable;

abstract class ProcessHandler implements ProcessHandlerContract
{
    use HandlesAuthorization;
    use HandlesFields;
    use HandlesValidation;
    use HandlesProcessEvents;
    use InteractsWithModel;
    use InteractsWithProcess;

    public static string $name = 'Process';

    public static string $group = 'processes';

    public static ?string $key = null;

    public static ?string $description = null;

    public function __construct(public Process $process)
    {
    }

    /**
     * Handle process.
     *
     * @param ProcessRequest $request
     * @return void
     * @throws Throwable
     */
    public function handle(ProcessRequest $request): void
    {
        $this->saveFields($request);

        // Ensures that updated model event is fired and
        // gives us the benefit of knowing when it was last saved
        $this->process->update(['saved_at' => Carbon::now()]);
    }

    /**
     * Determine if the process should be initialized.
     *
     * @param Processable $model
     * @return bool
     */
    public static function shouldInitialize(Processable $model): bool
    {
        return true;
    }

    /**
     * Determine if the process is finished.
     * List all conditions necessary here.
     *
     * @return bool
     */
    public function isComplete(): bool
    {
        if (Config::get('process.testing')) {
            return true;
        }

        return $this->allFieldsSaved();
    }

    /**
     * Return a fresh handler instance.
     *
     * @param Process|null $process
     * @return static
     */
    protected static function newHandler(?Process $process = null): static
    {
        return new static($process ?? new Process());
    }

    /**
     * Get process name.
     *
     * @return string
     */
    public static function name(): string
    {
        return self::newHandler()::$name;
    }

    /**
     * Get process group.
     *
     * @return string
     */
    public static function group(): string
    {
        return self::newHandler()::$group;
    }

    /**
     * Get process key.
     *
     * @return string
     */
    public static function key(): string
    {
        return self::newHandler()::$key ?? Str::slug(self::newHandler()::name());
    }

    /**
     * Get process description.
     *
     * @return ?string
     */
    public static function description(): ?string
    {
        return self::newHandler()::$description;
    }
}
