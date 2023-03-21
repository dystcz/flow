<?php

declare(strict_types=1);

namespace Dystcz\Flow\Domain\Fields\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use JsonSerializable;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class MediaResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|JsonSerializable
     */
    public function toArray($request)
    {
        /** @var Media $model */
        $model = $this->resource;

        return [
            'id' => $model->id,
            'path' => "{$model->id}/{$this->file_name}",
            'url' => $model->getUrl(),
            'name' => $model->file_name,
            'type' => $model->mime_type,
            'size' => $model->size,
            'collection_name' => $model->collection_name,
            'order' => $model->order_column,
        ];
    }
}
