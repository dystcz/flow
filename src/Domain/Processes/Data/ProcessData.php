<?php

namespace Dystcz\Process\Domain\Processes\Data;

use Illuminate\Contracts\Support\Arrayable;

class ProcessData implements Arrayable
{
    public function __construct(
        public int $process_template_id,
        public int $process_node_id,
        public string $handler_type,
        public string $name,
        public string $key,
        public string $group,
    ) {
    }

    public function toArray()
    {
        return [
            'process_template_id' => $this->process_template_id,
            'process_node_id' => $this->process_node_id,
            'handler_type' => $this->handler_type,
            'name' => $this->name,
            'key' => $this->key,
            'group' => $this->group,
        ];
    }
}
