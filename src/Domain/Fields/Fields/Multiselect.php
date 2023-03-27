<?php

declare(strict_types=1);

namespace Dystcz\Flow\Domain\Fields\Fields;

use Dystcz\Flow\Domain\Fields\Contracts\DataFieldContract;
use Dystcz\Flow\Domain\Flows\Contracts\FlowHandlerContract;

class Multiselect extends Field implements DataFieldContract
{
    public string $component = 'multiselect';

    public function __construct(
        public string $name,
        public string $key,
        public array $options = [],
        public mixed $value = null,
        public mixed $formattedValue = null,
    ) {
        parent::__construct($name, $key, $options, $value, $formattedValue);

        $this->handleRetrieve(function (Field $field, FlowHandlerContract $handler) {
            $value = $this->handler()->retrieve($this, $handler);

            return is_array($value) ? $value : [$value];
        });
    }
}
