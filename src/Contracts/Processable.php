<?php

namespace Dystcz\Process\Contracts;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

interface Processable
{
    /**
     * Processes relation.
     *
     * @return MorphMany
     */
    public function processes(): MorphMany;

    /**
     * Process template relation.
     *
     * @return BelongsTo
     */
    public function processTemplate(): BelongsTo;
}
