<?php

namespace Dystcz\Process\Traits;

use Dystcz\Process\Models\Process;
use Dystcz\Process\Models\ProcessTemplate;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait InteractsWithProcesses
{
    /**
     * Processes relation.
     *
     * @return MorphMany
     */
    public function processes(): MorphMany
    {
        return $this->morphMany(Process::class, 'model');
    }

    /**
     * Process template relation.
     *
     * @return BelongsTo
     */
    public function processTemplate(): BelongsTo
    {
        return $this->belongsTo(ProcessTemplate::class);
    }
}
