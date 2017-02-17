<?php

namespace TheIconic\Synopsis;

/**
 * represents anything not represented by any of the other synopsis classes
 *
 * @package TheIconic\Synopsis
 */
class StandardSynopsis extends AbstractSynopsis
{
    /**
     * @param $value
     * @param $depth
     */
    public function process($value, $depth)
    {
        parent::process($value, $depth);

        $this->type = $this->detectType($value);
    }

    /**
     * @param $value
     * @return string
     */
    protected function detectType($value)
    {
        if ($value === null) {
            $type = 'null';
        } elseif ($value instanceof Exception) {
            $type = 'exception';
        } else {
            $type = gettype($value);
        }

        return $type;
    }
}
