<?php

namespace Dystcz\Process\Models;

use Dystcz\Process\Collections\ProcessCollection;
use Dystcz\Process\Contracts\ProcessContract;
use Dystcz\Process\Handlers\ProcessHandler;
use Dystcz\Process\Traits\InteractsWithHandler;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Config;
use Kalnoy\Nestedset\NodeTrait;

class Process extends Model implements ProcessContract
{
    use InteractsWithHandler;
    use SoftDeletes;
    use NodeTrait;

    protected $dates = [
        'open' => 'boolean',
        'finished' => 'boolean',
    ];

    /**
     * Register Process eloquent collection.
     *
     * @param array $models
     * @return ProcessCollection
     */
    public function newCollection(array $models = []): ProcessCollection
    {
        return new ProcessCollection($models);
    }

    /**
     * Initialize the process handler.
     *
     * @return ProcessHandler
     */
    public function handler(): ProcessHandler
    {
        return new ($this->handler)($this);
    }

    /**
     * Check wether process is open.
     *
     * @return bool
     */
    public function isOpen(): bool
    {
        return $this->open;
    }

    /**
     * Check wether process is finished.
     *
     * @return bool
     */
    public function isFinished(): bool
    {
        return $this->finished;
    }

    /**
     * Process config relation.
     *
     * @return BelongsTo
     */
    public function config(): BelongsTo
    {
        return $this->belongsTo(Config::get('process.config.model'));
    }
}
