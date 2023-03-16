<?php

namespace Dystcz\Flow\Domain\Flows\Builders;

use Dystcz\Flow\Domain\Flows\Contracts\BuilderContract;
use Dystcz\Flow\Domain\Flows\Contracts\DTOContract;
use Dystcz\Flow\Domain\Flows\Data\NotificationData;
use Dystcz\Flow\Domain\Flows\Enums\NotificationType;
use Illuminate\Database\Eloquent\Model;

class NotificationDataBuilder implements BuilderContract
{
    /**
     * @param  array<string,mixed>  $relations
     * @param  array<string,mixed>  $meta
     */
    public function __construct(
        protected Model $model,
        protected NotificationType $type,
        protected string $description = 'Notification description',
        protected string $body = 'Notification body',
        protected array $relations = [],
        protected array $meta = [],
        protected string $dtoClass = NotificationData::class,
    ) {
    }

    /**
     * Create new instance.
     */
    public static function from(Model $model): self
    {
        $relations = [
            'model' => [
                'id' => $model->id,
                'type' => $model::class,
                'name' => $model->name,
                'table' => $model->getTable(),
            ],
        ];

        return new static(
            model: $model,
            type: NotificationType::NORMAL,
            relations: $relations,
        );
    }

    /**
     * Set description.
     */
    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Set body.
     */
    public function setBody(string $body): self
    {
        $this->body = $body;

        return $this;
    }

    /**
     * Set type.
     */
    public function setType(NotificationType $type): self
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Set relations.
     *
     * @param  array<string,mixed>  $relations
     */
    public function setRelations(array $relations): self
    {
        $this->relations = $relations;

        return $this;
    }

    /**
     * Set meta data.
     *
     * @param  array<string,mixed>  $meta
     */
    public function setMeta(array $meta): self
    {
        $this->meta = $meta;

        return $this;
    }

    /**
     * Set DTO class name.
     */
    public function setDTOClass(string $dtoClass): self
    {
        $this->dtoClass = $dtoClass;

        return $this;
    }

    /**
     * Build notification data.
     */
    public function build(): DTOContract
    {
        return new $this->dtoClass(
            type: $this->type,
            subject_id: $this->model->id,
            subject_type: $this->model::class,
            description: $this->description,
            body: $this->body,
            relations: $this->relations,
            meta: $this->meta,
        );
    }
}
