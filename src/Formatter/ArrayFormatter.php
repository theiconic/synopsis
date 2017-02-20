<?php

namespace TheIconic\Synopsis\Formatter;

use TheIconic\Synopsis\AbstractSynopsis;

/**
 * formats a synopsis tree in a format suitable for log files
 *
 * @package TheIconic\Synopsis\Formatter
 */
class ArrayFormatter extends AbstractFormatter
{
    /**
     * formats a synopsis object
     *
     * @param AbstractSynopsis $synopsis
     * @param string|null $key
     * @return string
     */
    public function format(AbstractSynopsis $synopsis)
    {
        $formatted = [
            'type' => $synopsis->getType(),
            'length' => $synopsis->getLength(),
            'value' => $synopsis->getValue(),
        ];

        if ($synopsis->hasChildren()) {
            $formatted['children'] = [];

            foreach ($synopsis->getChildren() as $k => $v) {
                $formatted['children'][$k] = $this->format($v);
            }
        }

        return $formatted;
    }
}
