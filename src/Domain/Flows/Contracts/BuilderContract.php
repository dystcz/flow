<?php

namespace Dystcz\Flow\Domain\Flows\Contracts;

use Illuminate\Database\Eloquent\Model;

interface BuilderContract
{
    /**
     * Create new instance.
     */
    public static function from(Model $model): self;

    /**
     * Build dto.
     */
    public function build(): DTOContract;
}
