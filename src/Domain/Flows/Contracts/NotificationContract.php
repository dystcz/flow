<?php

namespace Dystcz\Flow\Domain\Flows\Contracts;

use Dystcz\Flow\Domain\Flows\Builders\NotificationDataBuilder;
use Dystcz\Flow\Domain\Flows\Data\NotificationData;
use Illuminate\Notifications\Messages\MailMessage;

interface NotificationContract
{
    /**
     * Get the notification's delivery channels.
     */
    public function via(Notifiable $notifiable): array;

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(Notifiable $notifiable): MailMessage;

    /**
     * Get notification data builder.
     */
    public function dataBuilder(): NotificationDataBuilder;

    /**
     * Get notification data.
     */
    public function getData(): NotificationData;
}
