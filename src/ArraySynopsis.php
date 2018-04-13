<?php

namespace TheIconic\Synopsis;

/**
 * represents an array
 *
 * @package TheIconic\Synopsis
 */
class ArraySynopsis extends AbstractSynopsis
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
            $this->children = [];
            foreach ($value as $k => $v) {
                $this->addChild($this->getFactory()->synopsize($v, $depth), $k);
            }
        }

        $this->value = '';
    }
}
