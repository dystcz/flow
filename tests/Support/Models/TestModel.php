<?php

namespace Dystcz\Flow\Tests\Support\Models;

use Dystcz\Flow\Domain\Flows\Contracts\HasFlow;
use Dystcz\Flow\Domain\Flows\Traits\GoesWithTheFlow;
use Illuminate\Database\Eloquent\Model;

class TestModel extends Model implements HasFlow
{
    use GoesWithTheFlow;

    protected $table = 'test_models';

    protected $guarded = [];

    public $timestamps = false;
}
