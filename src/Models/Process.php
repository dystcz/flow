<?php

namespace Dystcz\Process\Models;

use Dystcz\Process\Traits\InteractsWithHandler;
use ProcessContract;

class Process extends Model implements ProcessContract
{
    use InteractsWithHandler;
}
