<?php

namespace Dystcz\Flow\Domain\Flows\Notifications;

use Dystcz\Flow\Domain\Flows\Builders\NotificationDataBuilder;
use Dystcz\Flow\Domain\Flows\Contracts\Notifiable;
use Dystcz\Flow\Domain\Flows\Contracts\NotificationContract;
use Dystcz\Flow\Domain\Flows\Data\NotificationData;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Mail\Mailable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification as BaseNotification;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;

class Notification extends BaseNotification implements NotificationContract
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(
        public Model $model,
        protected ?NotificationData $data = null,
    ) {
        $this->afterCommit();
    }

    /**
     * Get the notification's delivery channels.
     */
    public function via(Notifiable $notifiable): array
    {
        if (App::environment(['local', 'staging'])) {
            return ['database'];
        }

        return $notifiable->notificationChannels()
            ?? Config::get('flow.notifications.default_channels', ['database']);
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(Notifiable $notifiable): MailMessage|Mailable
    {
        return new MailMessage;
    }

    /**
     * Get the array representation of the notification.
     */
    public function toArray(Notifiable $notifiable): array
    {
        $data = $this->data ?? $this->getData($notifiable);

        return $data->toArray();
    }

    /**
     * Get notification data builder.
     */
    public function dataBuilder(): NotificationDataBuilder
    {
        return NotificationDataBuilder::from($this->model);
    }

    /**
     * Get notification data.
     */
    public function getData(): NotificationData
    {
        return $this->dataBuilder()->build();
    }
}
