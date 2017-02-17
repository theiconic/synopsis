<?php

namespace TheIconic\Synopsis;

/**
 * represents a string
 *
 * @package TheIconic\Synopsis
 */
class StringSynopsis extends AbstractSynopsis
{
    /**
     * the maximum length to which the string should be truncated
     */
    const MAX_LENGTH = 60;

    /**
     * @see parent::process()
     * @param $value
     * @param $depth
     */
    public function process($value, $depth)
    {
        parent::process($value, $depth);

        if (strlen($this->value) > self::MAX_LENGTH) {
            $this->value = substr($this->value, 0, (self::MAX_LENGTH / 2) - 2) . '...' . substr($this->value, (self::MAX_LENGTH / -2) + 1);
        }
    }
}
