<?php

namespace TheIconic\Synopsis\Formatter;

use PHPUnit\Framework\TestCase;
use TheIconic\Synopsis\ObjectSynopsis;

class ArrayFormatterTest extends TestCase
{
    /**
     * @var array
     */
    public $child = [
        'a' => 'c',
        'b' => 1,
        'c' => null
    ];

    /**
     *
     */
    public function testFormat()
    {
        $synopsis = new ObjectSynopsis();
        $synopsis->process(new self(), 3);

        $formatter = new ArrayFormatter();

        $this->assertEquals([
            'type' => __CLASS__,
            'length' => 1,
            'value' => '',
            'children' => [
                'child' => [
                    'type' => 'array',
                    'length' => 3,
                    'value' => '',
                    'children' => [
                        'a' => [
                            'type' => 'string',
                            'length' => 1,
                            'value' => 'c',
                        ],
                        'b' => [
                            'type' => 'integer',
                            'length' => 1,
                            'value' => 1,
                        ],
                        'c' => [
                            'type' => 'NULL',
                            'length' => 0,
                            'value' => ''
                        ],
                    ],
                ],
            ],
        ], $formatter->format($synopsis));
    }
}