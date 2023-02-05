<?php

namespace Dystcz\Process\Domain\Fields\Http\Resources;

use Dystcz\Process\Domain\Fields\FieldTypes\Field;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Resources\Json\JsonResource;
use JsonSerializable;

class FieldResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|Arrayable|JsonSerializable
     */
    public function toArray($request): array|JsonSerializable|Arrayable
    {
        /** @var Field $field */
        $field = $this->resource;

        return $field->toArray();
    }
}
