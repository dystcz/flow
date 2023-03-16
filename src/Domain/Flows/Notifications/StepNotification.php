<?php

namespace Dystcz\Flow\Domain\Flows\Notifications;

use Dystcz\Flow\Domain\Flows\Data\NotificationData;
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

    protected NotificationData $data;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(public Step $step)
    {
        $this->afterCommit();
    }

    /**
     * Get the notification's delivery channels.
     */
    public function via(Step $notifiable): array
    {
        if (App::environment(['local', 'staging'])) {
            return ['database'];
        }

        return Config::get('flow.notifications.default_channels', ['database']);
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return new MailMessage;
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return $this->getData()->toArray();
    }

    /**
     * Get notification data.
     */
    protected function getData(): NotificationData
    {
        return new NotificationData(
            subject_id: $this->step->id,
            subject_type: Step::class,
            description: "Pozvánka k procesu: {$this->step->name}",
            body: "proces {$this->step->name} čeká na Vaše odbavení.",
            relations: [
                'step' => [
                    'id' => $this->step->id,
                    'name' => $this->step->name,
                ],
                'project' => [
                    'id' => $this->step->model->id,
                    'name' => $this->step->model->name,
                ],
            ],
        );
    }
}
