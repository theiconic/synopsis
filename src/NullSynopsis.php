<?php

namespace TheIconic\Synopsis;

/**
 * represents the NULL value
 *
 * @package TheIconic\Synopsis
 */
class NullSynopsis extends AbstractSynopsis
{
    /**
     * @see parent::process()
     * @param $value
     * @param $depth
     */
    public function process($value, $depth)
    {
        $this->type = 'NULL';
    }
}
