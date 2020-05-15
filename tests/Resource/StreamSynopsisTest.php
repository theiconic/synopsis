<?php

namespace TheIconic\Synopsis\Resource;

use PHPUnit\Framework\TestCase;
use Exception;
use TheIconic\Synopsis\AbstractSynopsis;
use TheIconic\Synopsis\ArraySynopsis;
use TheIconic\Synopsis\Factory;
use TheIconic\Synopsis\StringSynopsis;

class StreamSynopsisTest extends TestCase
{
    /**
     *
     */
    public function testProcess()
    {
        $synopsis = new StreamSynopsis();
        $synopsis->process(STDIN, 3);

        $this->assertEquals('stream', $synopsis->getType());
        $this->assertEquals(11, $synopsis->getLength());
        $this->assertEquals('php://stdin', $synopsis->getValue());
        $this->assertFalse($synopsis->hasChildren());
        $this->assertEquals([], $synopsis->getChildren());
    }
}
