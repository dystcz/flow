<?php

namespace Dystcz\Process\Fields;

class MediaField extends Field
{
    public string $component = 'media';

    public string $collection = 'default';

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
     * @return MediaField
     */
    public function setMediaCollection(string $collection): self
    {
        $this->setConfig('collection_name', $collection);

        return $this;
    }
}
