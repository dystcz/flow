<?php

namespace Dystcz\Flow\Domain\Flows\Traits;

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
}
