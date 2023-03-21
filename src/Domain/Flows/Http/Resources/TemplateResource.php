<?php

declare(strict_types=1);

namespace Dystcz\Flow\Domain\Flows\Http\Resources;

use Dystcz\Flow\Domain\Flows\Models\Template;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Resources\Json\JsonResource;
use JsonSerializable;

class TemplateResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function toArray($request): array|JsonSerializable|Arrayable
    {
        /** @var Template $model */
        $model = $this->resource;

        return [
            'id' => $model->id,
            'model_type' => $model->model_type,
            'name' => $model->name,
        ];
    }
}
