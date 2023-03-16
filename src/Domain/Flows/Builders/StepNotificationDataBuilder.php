<?php

namespace Dystcz\Flow\Domain\Flows\Builders;

use Dystcz\Flow\Domain\Flows\Contracts\BuilderContract;
use Dystcz\Flow\Domain\Flows\Enums\NotificationType;
use Dystcz\Flow\Domain\Flows\Models\Step;
use Illuminate\Database\Eloquent\Model;

class StepNotificationDataBuilder extends NotificationDataBuilder implements BuilderContract
{
    /**
     * Create new instance.
     */
    public static function from(Model $model): self
    {
        /** @var Step $step */
        $step = $model;

        $relations = [
            'step' => [
                'id' => $step->id,
                'type' => $step::class,
                'name' => $step->name,
                'table' => $step->getTable(),
            ],
            'model' => [
                'id' => $step->model->id,
                'type' => $step->model::class,
                'name' => $step->model->name,
                'table' => $step->model->getTable(),
            ],
        ];

        return new static(
            model: $step,
            type: NotificationType::NORMAL,
            relations: $relations,
        );
    }
}
