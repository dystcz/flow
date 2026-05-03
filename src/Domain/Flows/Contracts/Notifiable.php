<?php

declare(strict_types=1);

namespace Dystcz\Flow\Domain\Flows\Contracts;

use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Query\Builder;
use Illuminate\Notifications\Notification;

interface Notifiable
{
    /**
     * Get the notification's delivery channels.
     */
    public function notificationChannels(): array;

    /**
     * Send the given notification.
     *
     * @param  mixed  $instance
     * @return void
     */
    public function notify($instance);

    /**
     * Send the given notification immediately.
     *
     * @param  mixed  $instance
     * @return void
     */
    public function notifyNow($instance, ?array $channels = null);

    /**
     * Get the notification routing information for the given driver.
     *
     * @param  string  $driver
     * @param  Notification|null  $notification
     * @return mixed
     */
    public function routeNotificationFor($driver, $notification = null);

    /**
     * Get the entity's notifications.
     *
     * @return MorphMany
     */
    public function notifications();

    /**
     * Get the entity's read notifications.
     *
     * @return Builder
     */
    public function readNotifications();

    /**
     * Get the entity's unread notifications.
     *
     * @return Builder
     */
    public function unreadNotifications();
}
