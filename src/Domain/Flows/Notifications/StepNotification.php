<?php

declare(strict_types=1);

namespace Dystcz\Flow\Domain\Flows\Notifications;

use Dystcz\Flow\Domain\Flows\Contracts\Notifiable;
use Dystcz\Flow\Domain\Flows\Data\NotificationData;
use Dystcz\Flow\Domain\Flows\Enums\NotificationType;
use Dystcz\Flow\Domain\Flows\Models\Step;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;

class StepNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(
        public Step $step,
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

        return $notifiable->notificationChannels() ?? Config::get('flow.notifications.default_channels', ['database']);
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(Notifiable $notifiable): MailMessage
    {
        return new MailMessage;
    }

    /**
     * Get the array representation of the notification.
     */
    public function toArray(Notifiable $notifiable): array
    {
        $data = $this->data ?? $this->getData();

        return  $data->toArray();
    }

    /**
     * Get notification data.
     */
    protected function getData(): NotificationData
    {
        return new NotificationData(
            type: NotificationType::NORMAL,
            subject_id: $this->step->id,
            subject_type: $this->step::class,
            description: 'Notification description',
            body: 'Something happened.',
            relations: [
                'step' => [
                    'id' => $this->step->id,
                    'name' => $this->step->name,
                ],
                'model' => [
                    'id' => $this->step->model->id,
                    'name' => $this->step->model->name,
                ],
            ],
        );
    }
}
