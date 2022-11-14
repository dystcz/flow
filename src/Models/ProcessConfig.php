<?php

namespace Dystcz\Process\Models;

use Dystcz\Process\Collections\ProcessConfigCollection;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Config;
use Kalnoy\Nestedset\NodeTrait;

class ProcessConfig extends Model
{
    use NodeTrait;
    use SoftDeletes;

    /**
     * Register Process config eloquent collection.
     *
     * @param array $models
     * @return ProcessCollection
     */
    public function newCollection(array $models = []): ProcessConfigCollection
    {
        return new ProcessConfigCollection($models);
    }

    /**
     * Processes that need to be finished in order to open this process.
     *
     * @return HasMany
     */
    public function blockingProcesses(): HasMany
    {
        return $this->hasMany(Config::get('process.config.model'));
    }

    /**
     * Responsible people relation.
     *
     * @return MorphToMany
     */
    public function responsiblePeople(): MorphToMany
    {
        return $this->morphToMany(
            Config::get('process.config.responsible_person_model'),
            'responsiblePeople',
            'process_responsibles'
        );
    }

    /**
     * Notifiable people relation.
     *
     * @return MorphToMany
     */
    public function notifiablePeople(): MorphToMany
    {
        return $this->morphToMany(
            Config::get('process.config.notifiable_person_model'),
            'notifiablePeople',
            'process_notifiables'
        );
    }
}
