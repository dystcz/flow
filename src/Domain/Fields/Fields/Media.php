<?php

namespace Dystcz\Process\Domain\Fields\Fields;

use Dystcz\Process\Domain\Fields\Contracts\MediaFieldContract;

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
