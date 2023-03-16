<?php

declare(strict_types=1);

namespace Dystcz\Flow\Domain\Flows\Notifications;

use Dystcz\Flow\Domain\Flows\Builders\NotificationDataBuilder;
use Dystcz\Flow\Domain\Flows\Builders\StepNotificationDataBuilder;
use Dystcz\Flow\Domain\Flows\Data\NotificationData;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Model;

class StepNotification extends Notification implements ShouldQueue
{
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(
        public Model $model,
        protected ?NotificationData $data = null,
    ) {
        parent::__construct($model, $data);
    }

    /**
     * Get notification data builder.
     */
    public function builder(): NotificationDataBuilder
    {
        return StepNotificationDataBuilder::from($this->model);
    }

    /**
     * Get notification data.
     */
    public function getData(): NotificationData
    {
        return $this->builder()
            ->setDescription('Notification description')
            ->setBody('Something happened.')
            ->build();
    }
}
