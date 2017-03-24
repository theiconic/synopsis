<?php

namespace TheIconic\Synopsis;

use Exception;

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
        } else if (is_object($value)) {
            $type = get_class($value);
        } else if (is_resource($value)) {
            $type = sprintf('%s resource', get_resource_type($value));
        } else {
            $type = gettype($value);
        }

        return $type;
    }
}
