<?php

namespace TheIconic\Synopsis;

use Exception;

/**
 * the synopsis factory spawns synopsis instances
 *
 * @package TheIconic\Synopsis
 */
class Factory
{

    /**
     * @var array mappings from value classes to synopsis classes
     */
    protected $objectMap = array(
        'Transfer_AbstractObject' => 'TransferObject',
        'Transfer_AbstractCollection' => 'TransferCollection',
        'Iterator' => 'Iterator',
        'IteratorAggregate' => 'Iterator',
        'ArrayAccess' => 'Iterator',
    );

    /**
     * @var array mappings from resource types to synopsis classes
     */
    protected $resourceMap = array(
        'bzip2' => 'File',
        'cpdf' => 'File',
        'fdf' => 'File',
        'zlib' => 'File',
        'stream' => 'Stream',
    );

    /**
     * creates the fitting synopsis instance for a value
     *
     * @param $value
     * @param $depth
     * @return mixed
     */
    public function synopsize($value, $depth)
    {
        if ($value === null) {
            $type = 'null';
        } elseif ($value instanceof Exception) {
            $type = 'exception';
        } else {
            $type = gettype($value);
        }

        if (!class_exists($className = __NAMESPACE__ . '\\' . ucfirst($type) . 'Synopsis')) {
            $className = __NAMESPACE__ . '\StandardSynopsis';
        }

        $subspace = ucfirst($type);
        if (method_exists($this, $method = sprintf('getClassNameFor%s', $subspace))) {
            $className = call_user_func([$this, $method], $value);
        }

        $depth--;
        if ($depth <= 0) {
            $depth = false;
        }

        /** @var AbstractSynopsis $synopsis */
        $synopsis = new $className();
        $synopsis->setFactory($this);
        $synopsis->process($value, $depth);

        return $synopsis;
    }

    /**
     * get the fitting synopsis class name for the given object
     *
     * @param $value
     * @return string
     */
    protected function getClassNameForObject($value)
    {
        foreach ($this->objectMap as $type => $className) {
            if (!(is_a($value, $type))) {
                continue;
            }

            $className = __NAMESPACE__ . '\Object\\' . $className . 'Synopsis';

            if (class_exists($className)) {
                return $className;
            }
        }

        return (__NAMESPACE__ . '\ObjectSynopsis');
    }

    /**
     * get the fitting synopsis class name for the given resource
     *
     * @param $value
     * @return string
     */
    protected function getClassNameForResource($value)
    {
        $type = get_resource_type($value);

        if (isset($this->resourceMap[$type])) {
            $className = __NAMESPACE__ . '\Resource\\' . $this->resourceMap[$type] . 'Synopsis';

            if (class_exists($className)) {
                return $className;
            }
        }

        return (__NAMESPACE__ . '\ResourceSynopsis');
    }

    /**
     * register a Synopsis class for resource type
     *
     * @param $type
     * @param $className
     * @return $this
     */
    public function addResourceType($type, $className)
    {
        $this->resourceMap[$type] = $className;

        return $this;
    }

    /**
     * register a Synopsis class for an object type
     *
     * @param $type
     * @param $className
     * @return $this
     */
    public function addType($type, $className)
    {
        $this->objectMap[$type] = $className;

        return $this;
    }
}
