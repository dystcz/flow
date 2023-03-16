<?php

namespace Dystcz\Flow\Domain\Flows\Contracts;

/**
 * Some flow steps can instantiate other steps even if they are not finished.
 * If they implement this interface, theit status will be updated to hold until the step is finished.
 */
interface HoldsUntilFinished
{
}
