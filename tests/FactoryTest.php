<?php

namespace TheIconic\Synopsis;

use PHPUnit\Framework\TestCase;
use SebastianBergmann\CodeCoverage\RuntimeException;
use TheIconic\Synopsis\Object\IteratorSynopsis;
use TheIconic\Synopsis\Resource\StreamSynopsis;
use ArrayIterator;

class FactoryTest extends TestCase
{
    public function provider()
    {
        return [
            [
                null,
                NullSynopsis::class,
            ],
            [
                true,
                BooleanSynopsis::class,
            ],
            [
                1,
                IntegerSynopsis::class,
            ],
            [
                'abc',
                StringSynopsis::class,
            ],
            [
                2.3,
                DoubleSynopsis::class,
            ],
            [
                ['a', 'b', 'c'],
                ArraySynopsis::class,
            ],
            [
                new self(),
                ObjectSynopsis::class,
            ],
            [
                STDIN,
                StreamSynopsis::class,
            ],
            [
                new ArrayIterator(['a', 'b', 'c']),
                IteratorSynopsis::class,
            ],
            [
                new RuntimeException(),
                ExceptionSynopsis::class,
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
}