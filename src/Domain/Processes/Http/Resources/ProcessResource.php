<?php

namespace Dystcz\Process\Domain\Processes\Http\Resources;

use Dystcz\Process\Domain\Fields\Http\Resources\FieldResource;
use Dystcz\Process\Domain\Fields\Http\Resources\MediaResource;
use Dystcz\Process\Models\Process;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Resources\Json\JsonResource;
use JsonSerializable;

class ProcessResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|Arrayable|JsonSerializable
     */
    public function toArray($request): array|JsonSerializable|Arrayable
    {
        /** @var Process $model */
        $model = $this->resource;

        return [
            'id' => $model->id,
            'name' => $model->name,
            'key' => $model->key,
            'group' => $model->group,
            'open' => $model->isOpen(),
            'finished' => $model->isFinished(),
            'attribute_data' => FieldResource::collection($model->attribute_data?->values() ?? []),
            'media' => MediaResource::collection($model->media),
        ];
    }
}
