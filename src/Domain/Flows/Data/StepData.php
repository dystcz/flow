<?php

namespace Dystcz\Flow\Domain\Flows\Data;

use Illuminate\Contracts\Support\Arrayable;

class StepData implements Arrayable
{
    public function __construct(
        public int $template_id,
        public int $node_id,
        public string $handler,
        public string $name,
        public string $key,
        public string $group,
    ) {
    }

    public function toArray(): array
    {
        return [
            'template_id' => $this->template_id,
            'node_id' => $this->node_id,
            'handler' => $this->handler,
            'name' => $this->name,
            'key' => $this->key,
            'group' => $this->group,
        ];
    }
}
