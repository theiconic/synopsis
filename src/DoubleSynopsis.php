<?php

namespace TheIconic\Synopsis;

/**
 * represents a number with double or float precision
 *
 * @package TheIconic\Synopsis
 */
class DoubleSynopsis extends AbstractSynopsis
{

    /**
     * @see parent::process()
     * @param $value
     * @param $depth
     */
    public function process($value, $depth)
    {
        parent::process($value, $depth);

        $this->length = strlen((string) $value);
    }
}
