<?php

namespace Dystcz\Process\Domain\Fields\Fields;

use Dystcz\Process\Domain\Fields\Contracts\FieldHandlerContract;
use Dystcz\Process\Domain\Fields\Contracts\MediaFieldContract;
use Dystcz\Process\Domain\Fields\Handlers\MediaFieldHandler;

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
     *
     * @return FieldHandlerContract
     */
    public function handler(): FieldHandlerContract
    {
        return new MediaFieldHandler;
    }

    /**
     * Set media collection.
     *
     * @param string $collection
     * @return self
     */
    public function setMediaCollection(string $collection): self
    {
        $this->setConfigKey('collection_name', $this->key);

        return $this;
    }
}
