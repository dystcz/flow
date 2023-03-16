<?php

declare(strict_types=1);

namespace Dystcz\Flow\Domain\Flows\Notifications;

use Dystcz\Flow\Domain\Flows\Builders\NotificationDataBuilder;
use Dystcz\Flow\Domain\Flows\Builders\StepNotificationDataBuilder;
use Dystcz\Flow\Domain\Flows\Data\NotificationData;
use Dystcz\Flow\Domain\Flows\Models\Step;
use Illuminate\Contracts\Queue\ShouldQueue;

class StepNotification extends BaseNotification implements ShouldQueue
{
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(
        public Step $model,
        protected ?NotificationData $data = null,
    ) {
        parent::__construct($model, $data);
    }

    /**
     * Get notification data builder.
     */
    public function dataBuilder(): NotificationDataBuilder
    {
        return StepNotificationDataBuilder::from($this->model);
    }

    /**
     * Get notification data.
     */
    public function getData(): NotificationData
    {
        return $this->dataBuilder()
            ->setDescription('Notification description')
            ->setBody('Something happened.')
            ->build();
    }
}
