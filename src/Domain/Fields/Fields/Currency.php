<?php

declare(strict_types=1);

namespace Dystcz\Flow\Domain\Fields\Fields;

use Dystcz\Flow\Domain\Fields\Contracts\DataFieldContract;
use Dystcz\Flow\Domain\Flows\Contracts\FlowHandlerContract;

class Currency extends Field implements DataFieldContract
{
    public string $component = 'currency';

    public function __construct(
        public string $name,
        public string $key,
        public array $options = [],
        public mixed $value = null,
        public mixed $formattedValue = null,
    ) {
        parent::__construct($name, $key, $options, $value, $formattedValue);

        $this->handleFormat(function (Field $field, FlowHandlerContract $fieldHandler) {
            // TODO: Make currency symbol configurable
            $currencySymbol = $field->getConfigKey('currency_symbol', 'CZK');
            $formattedValue = number_format((float) $field->getValue(), 2, ',', ' ');

            return "{$formattedValue} {$currencySymbol}";
        });
    }
}
