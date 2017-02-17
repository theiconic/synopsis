<?php

namespace TheIconic\Synopsis\Resource;

use TheIconic\Synopsis\ResourceSynopsis;

/**
 * represents a stream resource
 *
 * @package TheIconic\Synopsis\Object
 */
class StreamSynopsis extends ResourceSynopsis
{
    /**
     * @param $value
     * @param $depth
     */
    public function process($value, $depth)
    {
        parent::process($value, $depth);

        $meta = stream_get_meta_data($value);

        $this->value = $meta['uri'];
        $this->length = strlen($this->value);
    }
}
