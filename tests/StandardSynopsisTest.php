<?php

namespace TheIconic\Synopsis;

use PHPUnit\Framework\TestCase;
use Exception;
use TheIconic\Synopsis\AbstractSynopsis;
use TheIconic\Synopsis\ArraySynopsis;
use TheIconic\Synopsis\Factory;
use TheIconic\Synopsis\StringSynopsis;

class StandardSynopsisTest extends TestCase
{
    /**
     * @return array
     */
    public function provider()
    {
        return [
            [
                'Hello World!',
                'string',
                12,
                'Hello World!',
            ],
            [
                4,
                'integer',
                1,
                4
            ],
            [
                2.3,
                'double',
                3,
                2.3
            ]
        ];
    }

    /**
     * @dataProvider provider
     */
    public function testProcess($original, $type, $length, $value)
    {
        $synopsis = new StandardSynopsis();
        $synopsis->process($original, 3);

        $this->assertEquals($type, $synopsis->getType());
        $this->assertEquals($length, $synopsis->getLength());
        $this->assertEquals($value, $synopsis->getValue());
        $this->assertFalse($synopsis->hasChildren());
        $this->assertNull($synopsis->getChildren());
    }
}