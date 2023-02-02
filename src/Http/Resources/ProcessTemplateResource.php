<?php

namespace Dystcz\Process\Http\Resources;

use Dystcz\Process\Models\ProcessTemplate;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Resources\Json\JsonResource;
use JsonSerializable;

class ProcessTemplateResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|Arrayable|JsonSerializable
     */
    public function toArray($request): array|JsonSerializable|Arrayable
    {
        /** @var ProcessTemplate $model */
        $model = $this->resource;

        return [
            'id' => $model->id,
            'model_type' => $model->model_type,
            'name' => $model->name,
        ];
    }
}
