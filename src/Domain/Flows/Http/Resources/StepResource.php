<?php

declare(strict_types=1);

namespace Dystcz\Flow\Domain\Flows\Http\Resources;

use Dystcz\Flow\Domain\Fields\Http\Resources\FieldResource;
use Dystcz\Flow\Domain\Fields\Http\Resources\MediaResource;
use Dystcz\Flow\Domain\Flows\Models\Step;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Resources\Json\JsonResource;
use JsonSerializable;

class StepResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function toArray($request): array|JsonSerializable|Arrayable
    {
        /** @var Step $model */
        $model = $this->resource;

        return [
            'id' => $model->id,
            'name' => $model->name,
            'key' => $model->key,
            'group' => $model->group,
            'open' => $model->isOpen(),
            'finished' => $model->isFinished(),
            'step_attributes' => FieldResource::collection($model->{Step::stepAttributesField()}->values() ?? []),
            'media' => MediaResource::collection($model->media),
        ];
    }
}
