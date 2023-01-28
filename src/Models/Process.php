<?php

namespace Dystcz\Process\Models;

use Dystcz\Process\Collections\ProcessCollection;
use Dystcz\Process\Contracts\ProcessContract;
use Dystcz\Process\Handlers\ProcessHandler;
use Dystcz\Process\Traits\InteractsWithHandler;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Config;

class Process extends Model implements ProcessContract
{
    use InteractsWithHandler;
    use SoftDeletes;

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
     * ProcessNode relation.
     *
     * @return BelongsTo
     */
    public function node(): BelongsTo
    {
        return $this->belongsTo(Config::get('process.nodes.model'));
    }
}
