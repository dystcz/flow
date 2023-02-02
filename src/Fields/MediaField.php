<?php

namespace Dystcz\Process\Fields;

use Dystcz\Process\Contracts\MediaFieldContract;

class MediaField extends Field implements MediaFieldContract
{
    public string $component = 'media';

    public string $collection = 'default';

    public bool $saveToAttributes = false;

    public function __construct(
        public string $name,
        public string $key,
        public array $options = [],
        public mixed $value = null,
    ) {
        parent::__construct($name, $key, $options, $value);

        $this->setMediaCollection($this->collection);
    }

    /**
     * Set media collection.
     *
     * @param string $collection
     * @return self
     */
    public function setMediaCollection(string $collection): self
    {
        $this->setConfig('collection_name', $collection);

        return $this;
    }
}
