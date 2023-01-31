<?php

namespace Dystcz\Process\Data;

use Spatie\LaravelData\Data;

class ProcessData extends Data
{
    public function __construct(
        public int $process_template_id,
        public int $process_node_id,
        public string $handler,
        public string $title,
        public string $key,
        public string $group,
    ) {
    }
}
