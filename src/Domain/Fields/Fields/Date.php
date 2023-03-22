<?php

declare(strict_types=1);

namespace Dystcz\Flow\Domain\Fields\Fields;

use Dystcz\Flow\Domain\Fields\Contracts\DataFieldContract;
use Dystcz\Flow\Domain\Flows\Contracts\FlowHandlerContract;
use Illuminate\Support\Carbon;

class Date extends Field implements DataFieldContract
{
    public string $component = 'date';

    public function __construct(
        public string $name,
        public string $key,
        public array $options = [],
        public mixed $value = null,
        public mixed $formattedValue = null,
    ) {
        parent::__construct($name, $key, $options, $value, $formattedValue);

        $this->handleFormat(function (Field $field, FlowHandlerContract $fieldHandler) {
            // TODO: Make format configurable
            return $field->getValue() ? Carbon::parse($field->getValue())->format('j. n. Y') : null;
        });
    }
}
