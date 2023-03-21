<?php

declare(strict_types=1);

namespace Dystcz\Flow\Domain\Flows\Contracts;

use Illuminate\Database\Eloquent\Model;

interface BuilderContract
{
    /**
     * Create new instance.
     */
    public static function from(Model $model): self;

    /**
     * Set DTO class name.
     */
    public function setDTOClass(string $dtoClass): self;

    /**
     * Build DTO.
     */
    public function build(): DTOContract;
}
