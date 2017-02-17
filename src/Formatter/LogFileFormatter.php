<?php

namespace TheIconic\Synopsis\Formatter;

use TheIconic\Synopsis\AbstractSynopsis;

/**
 * formats a synopsis tree in a format suitable for log files
 *
 * @package TheIconic\Synopsis\Formatter
 */
class LogFileFormatter
{
    /**
     * @var int the current level in the tree
     */
    protected $level = 0;

    /**
     * formats a synopsis object
     *
     * @param AbstractSynopsis $synopsis
     * @param string|null $key
     * @return string
     */
    public function format(AbstractSynopsis $synopsis, $key = null)
    {
        $formatted = array();

        if (method_exists($this, $method = sprintf('format%s', get_class($synopsis)))) {
            $formatted[] = call_user_func(array($this, $method), $synopsis, $key);
        } else {
            if ($synopsis->hasChildren()) {
                $formatted[] = $this->formatTreeSynopsis($synopsis, $key);
            } else {
                $formatted[] = $this->formatScalarSynopsis($synopsis, $key);
            }
        }

        return implode(PHP_EOL, $formatted);
    }

    /**
     * formats a synopsis object with children
     *
     * @param AbstractSynopsis $synopsis
     * @param string|null $key
     * @return string
     */
    protected function formatTreeSynopsis(AbstractSynopsis $synopsis, $key)
    {
        $formatted = array(
            sprintf('%s (%s [%d]): %s', $key, $synopsis->getType(), $synopsis->getLength(), $synopsis->getValue()),
        );

        $this->level++;
        foreach ($synopsis->getChildren() as $k => $v) {
            $formatted[] = str_repeat(' ', $this->level * 2) . $this->format($v, $k);
        }
        $this->level--;

        return implode(PHP_EOL, $formatted);
    }

    /**
     * formats a synopsis object without children
     *
     * @param AbstractSynopsis $synopsis
     * @param $key
     * @return string
     */
    protected function formatScalarSynopsis(AbstractSynopsis $synopsis, $key)
    {
        return sprintf('%s (%s [%d]): %s', $key, $synopsis->getType(), $synopsis->getLength(), $synopsis->getValue());
    }
}
