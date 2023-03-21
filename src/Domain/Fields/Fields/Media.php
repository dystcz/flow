<?php

declare(strict_types=1);

namespace Dystcz\Flow\Domain\Fields\Fields;

use Dystcz\Flow\Domain\Fields\Contracts\FieldHandlerContract;
use Dystcz\Flow\Domain\Fields\Contracts\MediaFieldContract;
use Dystcz\Flow\Domain\Fields\Handlers\MediaFieldHandler;

class Media extends Field implements MediaFieldContract
{
    public string $component = 'media';

    public function __construct(
        public string $name,
        public string $key,
        public array $options = [],
        public mixed $value = null,
    ) {
        parent::__construct($name, $key, $options, $value);

        $this->setMediaCollection($this->key);
    }

    /**
     * Get field handler.
     */
    public function handler(): FieldHandlerContract
    {
        return new MediaFieldHandler;
    }

    /**
     * Set media collection.
     */
    public function setMediaCollection(string $collection): self
    {
        $this->setConfigKey('collection_name', $this->key);

        return $this;
    }
}
