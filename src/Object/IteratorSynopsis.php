<?php

namespace TheIconic\Synopsis\Object;

use TheIconic\Synopsis\ObjectSynopsis;

/**
 * represents an iterable object
 *
 * @package TheIconic\Synopsis\Object
 */
class IteratorSynopsis extends ObjectSynopsis
{
    /**
     * @see parent::process()
     * @param $value
     * @param $depth
     */
    public function process($value, $depth)
    {
        parent::process($value, $depth);

        if ($depth) {
            foreach ($value as $k => $v) {
                $this->addChild($this->getFactory()->synopsize($v, $depth), $k);
            }
        }

        $this->length = count($this->children);
    }
}
