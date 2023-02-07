<?php

namespace Dystcz\Process\Domain\Processes\Collections;

use Dystcz\Process\Domain\Processes\Models\Process;
use Illuminate\Database\Eloquent\Collection;

class ProcessCollection extends Collection
{
    public function markActiveProcess(): self
    {
        $this->reverse()->reduce(function ($carry, Process $process) {
            if ($carry || $process->isFinished()) {
                $process->setAttribute('active', false);

                return $carry;
            }

            if (!$carry && $process->isOpen()) {
                $process->setAttribute('active', true);
                $carry = true;
            }

            return $carry;
        }, false);

        return $this;
    }
}
