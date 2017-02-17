<?php

namespace TheIconic\Synopsis;

/**
 * represents a boolean value
 *
 * @package TheIconic\Synopsis
 */
class BooleanSynopsis extends AbstractSynopsis
{
    /**
     * @see parent::process()
     * @param $value
     * @param $depth
     */
    public function process($value, $depth)
    {
        parent::process($value, $depth);

        $this->value = ($value) ? 'true' : 'false';
    }
}
