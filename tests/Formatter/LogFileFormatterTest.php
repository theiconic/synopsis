<?php

namespace TheIconic\Synopsis\Formatter;

use PHPUnit\Framework\TestCase;
use TheIconic\Synopsis\ObjectSynopsis;

class LogFileFormatterTest extends TestCase
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

        $formatter = new LogFileFormatter();

        $expectation = <<<EOF
Test (TheIconic\Synopsis\Formatter\LogFileFormatterTest [1]): 
  child (array [3]): 
    a (string [1]): c
    b (integer [1]): 1
    c (NULL [0]): 
EOF;

        $this->assertEquals($expectation, $formatter->format($synopsis, 'Test'));
    }
}