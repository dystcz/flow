<?php

namespace Dystcz\Flow\Domain\Flows\Contracts;

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
    public function notifyNow($instance, array $channels = null);

    /**
     * Get the notification routing information for the given driver.
     *
     * @param  string  $driver
     * @param  \Illuminate\Notifications\Notification|null  $notification
     * @return mixed
     */
    public function routeNotificationFor($driver, $notification = null);

    /**
     * Get the entity's notifications.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function notifications();

    /**
     * Get the entity's read notifications.
     *
     * @return \Illuminate\Database\Query\Builder
     */
    public function readNotifications();

    /**
     * Get the entity's unread notifications.
     *
     * @return \Illuminate\Database\Query\Builder
     */
    public function unreadNotifications();
}
