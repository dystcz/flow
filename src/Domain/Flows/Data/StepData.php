<?php

declare(strict_types=1);

namespace Dystcz\Flow\Domain\Flows\Data;

class StepData extends DTO
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

    /**
     * Cast to array.
     */
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
