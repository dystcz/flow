<?php

namespace Dystcz\Process\Domain\Processes\Handlers;

use Dystcz\Process\Domain\Processes\Contracts\ProcessHandlerContract;
use Dystcz\Process\Domain\Processes\Http\Requests\ProcessRequest;
use Dystcz\Process\Domain\Processes\Models\Process;
use Dystcz\Process\Domain\Processes\Traits\HandlesAuthorization;
use Dystcz\Process\Domain\Processes\Traits\HandlesFields;
use Dystcz\Process\Domain\Processes\Traits\HandlesProcessEvents;
use Dystcz\Process\Domain\Processes\Traits\HandlesValidation;
use Dystcz\Process\Domain\Processes\Traits\InteractsWithModel;
use Dystcz\Process\Domain\Processes\Traits\InteractsWithProcess;
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

    public static ?string $key = null;

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
    }

    /**
     * Determine if the process is finished.
     * List all conditions necessary here.
     *
     * @return bool
     */
    public function isComplete(): bool
    {
        return $this->allFieldsSaved();
    }

    /**
     * Return a fresh handler instance.
     *
     * @return static
     */
    protected static function newHandler()
    {
        return new static(new Process);
    }

    /**
     * Get process name.
     *
     * @return string
     */
    public static function name(): string
    {
        return self::$name;
    }

    /**
     * Get process key.
     *
     * @return string
     */
    public static function key(): string
    {
        return self::$key ?? Str::slug(self::name());
    }
}
