<?php

namespace Dystcz\Process\Models;

use Dystcz\Process\Collections\ProcessTemplateCollection;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProcessTemplate extends Model
{
    use SoftDeletes;

    /**
     * Register Process template eloquent collection.
     *
     * @param array $models
     * @return ProcessTemplateCollection
     */
    public function newCollection(array $models = []): ProcessTemplateCollection
    {
        return new ProcessTemplateCollection($models);
    }
}
