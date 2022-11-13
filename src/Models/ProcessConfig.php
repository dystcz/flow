<?php

namespace Dystcz\Process\Models;

use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Support\Facades\Config;
use Kalnoy\Nestedset\NodeTrait;

class ProcessConfig extends Model
{
    use NodeTrait;

    /**
     * Responsible people relation.
     *
     * @return MorphToMany
     */
    public function responsiblePeople(): MorphToMany
    {
        return $this->morphToMany(
            Config::get('process.process_config.responsible_person_model'),
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
            Config::get('process.process_config.notifiable_person_model'),
            'notifiablePeople',
            'process_notifiables'
        );
    }
}
