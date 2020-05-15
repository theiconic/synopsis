<?php

namespace TheIconic\Synopsis;

use PHPUnit\Framework\TestCase;
use Exception;

class StandardSynopsisTest extends TestCase
{
    /**
     * @return array
     */
    public function provider()
    {
        return [
            'Hello World!' => [
                'Hello World!',
                'string',
                12,
                'Hello World!',
            ],
            '4' => [
                4,
                'integer',
                1,
                '4',
            ],
            '2.3' => [
                2.3,
                'double',
                3,
                '2.3',
            ],
            'null' => [
                null,
                'null',
                0,
                '',
            ],
            'exception' => [
                new Exception('testException'),
                'Exception',
                0,
                '',
            ],
            'stdin' => [
                STDIN,
                'stream resource',
                0,
                '',
            ],

        ];
    }

    /**
     * @dataProvider provider
     */
    public function testProcess($original, $type, $length, $value)
    {
        $synopsis = new StandardSynopsis();
        $synopsis->process($original, 3);

        $this->assertSame($type, $synopsis->getType());
        $this->assertSame($length, $synopsis->getLength());
        $this->assertSame($value, $synopsis->getValue());
        $this->assertFalse($synopsis->hasChildren());
        $this->assertEquals([], $synopsis->getChildren());
    }
}
