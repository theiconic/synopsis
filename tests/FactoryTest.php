<?php

namespace TheIconic\Synopsis;

use PHPUnit\Framework\TestCase;
use RuntimeException;
use TheIconic\Synopsis\Object\IteratorSynopsis;
use TheIconic\Synopsis\Resource\StreamSynopsis;
use ArrayIterator;

class FactoryTest extends TestCase
{
    /**
     * @var resource
     */
    protected static $socket;

    public static function tearDownAfterClass()
    {
        socket_close(self::$socket);
    }

    public function provider()
    {
        self::$socket = socket_create(AF_UNIX, SOCK_STREAM, 0);

        return [
            'null' => [
                null,
                NullSynopsis::class,
            ],
            'true' => [
                true,
                BooleanSynopsis::class,
            ],
            '1' => [
                1,
                IntegerSynopsis::class,
            ],
            'abc' => [
                'abc',
                StringSynopsis::class,
            ],
            '2.3' => [
                2.3,
                DoubleSynopsis::class,
            ],
            'array' => [
                ['a', 'b', 'c'],
                ArraySynopsis::class,
            ],
            'FactoryTest' => [
                new self(),
                ObjectSynopsis::class,
            ],
            'stream' => [
                STDIN,
                StreamSynopsis::class,
            ],
            'iterator' => [
                new ArrayIterator(['a', 'b', 'c']),
                IteratorSynopsis::class,
            ],
            'exception' => [
                new RuntimeException('test'),
                ExceptionSynopsis::class,
            ],
            'unknown resource' => [
                $this->getInvalidResourceHandle(),
                StandardSynopsis::class,
            ],
            'socket' => [
                self::$socket,
                ResourceSynopsis::class,
            ]
        ];
    }

    /**
     * @dataProvider provider
     *
     * @param $value
     * @param $className
     */
    public function testSynopsize($value, $className)
    {
        $factory = new Factory();

        $this->assertInstanceOf($className, $factory->synopsize($value, 3));
    }

    public function testSetters()
    {
        $factory = new Factory();

        $this->assertSame($factory, $factory->addType('custom', StandardSynopsis::class));
        $this->assertSame($factory, $factory->addObjectType(Factory::class, ObjectSynopsis::class));
        $this->assertSame($factory, $factory->addResourceType('socket', ResourceSynopsis::class));
    }

    /**
     * @return resource
     */
    protected function getInvalidResourceHandle()
    {
        $handle = fopen('php://memory', 'w+');
        fclose($handle);

        return $handle;
    }
}