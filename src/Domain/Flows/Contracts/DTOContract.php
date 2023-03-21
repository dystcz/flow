<?php

declare(strict_types=1);

namespace Dystcz\Flow\Domain\Flows\Contracts;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use JsonSerializable;

interface DTOContract extends Arrayable, JsonSerializable, Jsonable
{
}
