<?php

declare(strict_types=1);

namespace Dystcz\Flow\Domain\Flows\Models;

use Dystcz\Flow\Domain\Flows\Casts\NotificationDataCast;
use Dystcz\Flow\Domain\Flows\Contracts\Notifiable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Notifications\DatabaseNotification as BaseDatabaseNotification;
use Illuminate\Support\Collection;

class DatabaseNotification extends BaseDatabaseNotification
{
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'data' => NotificationDataCast::class,
        'read_at' => 'datetime',
    ];

    /**
     * Scope notifications for a model.
     */
    public function scopeNotifiable(Builder $builder, Notifiable $model): Builder
    {
        return $builder
            ->where('notifiable_id', $model->id)
            ->where('notifiable_type', $model::class);
    }

    /**
     * Scope notifications for multiple models.
     *
     * @param  Collection<Notifiable>  $models
     */
    public function scopeNotifiables(Builder $builder, Collection $models): Builder
    {
        if ($models->isEmpty()) {
            return $builder;
        }

        return $builder
            ->whereIn('notifiable_id', $models->pluck('id')->toArray())
            ->where('notifiable_type', $models->first()::class);
    }
}
