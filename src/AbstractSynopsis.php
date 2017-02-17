<?php

namespace TheIconic\Synopsis;

use Countable;

/**
 * Represents a synopsis of a value (or object), that is a description of the value useful
 * for debugging purposes
 *
 * @package TheIconic\Synopsis
 */
abstract class AbstractSynopsis
{

    /**
     * @var string the type
     */
    protected $type;

    /**
     * @var mixed the value - as in a presentable string
     */
    protected $value;

    /**
     * @var int the length or count
     */
    protected $length;

    /**
     * @var array the kiddos
     */
    protected $children;

    /**
     * @var Factory the synopsis factory (used for cascaded creation of synopsises)
     */
    protected $factory;

    /**
     * processes passed values to properties
     *
     * @param $value
     * @param $depth
     */
    public function process($value, $depth)
    {
        $this->type = strtolower(str_replace('Synopsis', '', str_replace(__NAMESPACE__ . '\\', '', get_class($this))));

        if (is_scalar($value)) {
            $this->value = (string) $value;
            $this->length = strlen((string) $value);
        } else {
            if ($this->value instanceof Countable) {
                $this->length = count($value);
            }
        }
    }

    /**
     * get the type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * get the length
     *
     * @return int
     */
    public function getLength()
    {
        if (null !== $this->length) {
            return $this->length;
        }

        if ($this->hasChildren()) {
            return count($this->children);
        }

        return 0;
    }

    /**
     * get the value
     *
     * @return string
     */
    public function getValue()
    {
        return (string) $this->value;
    }

    /**
     * get the children
     *
     * @return array
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * check if we have children
     *
     * @return bool
     */
    public function hasChildren()
    {
        return (bool) count($this->children);
    }

    /**
     * add a child
     *
     * @param $child
     * @param $key
     */
    public function addChild($child, $key)
    {
        $this->children[$key] = $child;
    }

    /**
     * get the synopsis factory
     *
     * @return Factory
     */
    public function getFactory()
    {
        if (!$this->factory) {
            $this->factory = new Factory();
        }

        return $this->factory;
    }

    /**
     * set a synopsis factory
     *
     * @param Factory $factory
     * @return $this
     */
    public function setFactory(Factory $factory)
    {
        $this->factory = $factory;

        return $this;
    }
}
