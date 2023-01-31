<?php

namespace Dystcz\Process\Http\Resources;

use Dystcz\Process\Models\Process;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Resources\Json\JsonResource;
use JsonSerializable;

abstract class ProcessResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|Arrayable|JsonSerializable
     */
    public function toArray($request): array|JsonSerializable|Arrayable
    {
        /** @var Process $process */
        $process = $this->resource;

        return [
            //
        ];
    }
}
