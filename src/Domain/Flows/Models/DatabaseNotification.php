<?php

declare(strict_types=1);

namespace Dystcz\Flow\Domain\Flows\Models;

use Dystcz\Flow\Domain\Flows\Casts\NotificationDataCast;
use Illuminate\Notifications\DatabaseNotification as BaseDatabaseNotification;

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
}
