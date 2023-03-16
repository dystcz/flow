<?php

declare(strict_types=1);

namespace Dystcz\Flow\Domain\Flows\Traits;

use Dystcz\Flow\Domain\Flows\Models\DatabaseNotification;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Config;

trait InteractsWithNotifications
{
    use Notifiable;

    /**
     * Get the notification's delivery channels.
     */
    public function notificationChannels(): array
    {
        // return $notifiable->prefers_sms ? ['vonage'] : ['mail', 'database'];

        return Config::get('flow.notifications.default_channels', ['database']);
    }

    /**
     * Get model's notifications.
     */
    public function notifications(): MorphMany
    {
        return $this
            ->morphMany(DatabaseNotification::class, 'notifiable')
            ->latest();
    }
}
