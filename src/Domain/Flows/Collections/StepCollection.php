<?php

namespace Dystcz\Flow\Domain\Flows\Collections;

use Dystcz\Flow\Domain\Flows\Models\Step;
use Illuminate\Database\Eloquent\Collection;

class StepCollection extends Collection
{
    public function markActiveStep(): self
    {
        $this->reverse()->reduce(function ($carry, Step $step) {
            if ($carry || $step->isFinished()) {
                $step->setAttribute('active', false);

                return $carry;
            }

            if (!$carry && $step->isOpen()) {
                $step->setAttribute('active', true);
                $carry = true;
            }

            return $carry;
        }, false);

        return $this;
    }
}
