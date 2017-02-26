<?php

namespace TheIconic\Synopsis\Exception;

use TheIconic\Synopsis\AbstractSynopsis;

/**
 * represents an exception trace line
 *
 * @package TheIconic\Synopsis\Exception
 */
class TraceSynopsis extends AbstractSynopsis
{
    /**
     * @var string the file
     */
    protected $file;

    /**
     * @var int the line
     */
    protected $line;

    /**
     * @var string the class
     */
    protected $class;

    /**
     * @var string the function
     */
    protected $function;

    /**
     * @see parent::process()
     * @param $value
     * @param $depth
     */
    public function process($value, $depth)
    {
        parent::process($value, $depth);

        $this->type = sprintf('%s()', (!empty($value['class'])) ? ($value['class'] . $value['type'] . $value['function']) : $value['function']);

        if (isset($value['file'])) {
            $this->value = $this->file = $value['file'];
        }

        if (isset($value['line'])) {
            $this->line = $value['line'];
            $this->value = sprintf('%s (%d)', $this->file, $this->line);
        }

        if (!empty($value['class'])) {
            $this->class = $value['class'];
        }

        $this->function = $value['function'];

        if (isset($value['args'])) {
            $this->length = count($value['args']);

            if ($depth) {
                foreach ($value['args'] as $k => $v) {
                    $this->addChild($this->getFactory()->synopsize($v, $depth), $k);
                }
            }
        }
    }

    /**
     * @return array
     */
    public function getDetails()
    {
        return [
            'line' => $this->line,
            'file' => $this->file,
            'class' => $this->class,
            'function' => $this->function,
        ];
    }

    /**
     * get the file
     *
     * @return string
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * get the line
     *
     * @return int
     */
    public function getLine()
    {
        return $this->line;
    }

    /**
     * get the class
     *
     * @return string
     */
    public function getClass()
    {
        return $this->class;
    }

    /**
     * get the function
     *
     * @return string
     */
    public function getFunction()
    {
        return $this->function;
    }
}
