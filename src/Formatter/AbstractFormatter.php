<?php

namespace TheIconic\Synopsis\Formatter;

use TheIconic\Synopsis\AbstractSynopsis;

/**
 * Class AbstractFormatter
 * @package TheIconic\Synopsis\Formatter
 */
abstract class AbstractFormatter
{

    /**
     * @param AbstractSynopsis $synopsis
     * @param string|null $key
     * @return mixed
     */
    abstract public function format(AbstractSynopsis $synopsis, $key = null);
}
