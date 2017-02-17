<?php

namespace TheIconic\Synopsis\Object;

use TheIconic\Synopsis\ObjectSynopsis;

/**
 * represents a Transfer Object
 *
 * @package TheIconic\Synopsis\Object
 */
class TransferObjectSynopsis extends ObjectSynopsis
{
    /**
     * @see parent::process()
     * @param $value
     * @param $depth
     */
    public function process($value, $depth)
    {
        parent::process($value, $depth);

        $props = $value->getRawData();
        foreach ($props as $k => $v) {
            $this->addChild($this->getFactory()->synopsize($v, 3), $k);
        }

        $this->length = count($this->children);
    }
}
