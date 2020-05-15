<?php

namespace TheIconic\Synopsis;

use PHPUnit\Framework\TestCase;
use Exception;
use TheIconic\Synopsis\AbstractSynopsis;
use TheIconic\Synopsis\ArraySynopsis;
use TheIconic\Synopsis\Factory;
use TheIconic\Synopsis\StringSynopsis;

class StringSynopsisTest extends TestCase
{
    /**
     *
     */
    public function testProcess()
    {
        $synopsis = new StringSynopsis();
        $synopsis->process('Hello World!', 3);

        $this->assertEquals('string', $synopsis->getType());
        $this->assertEquals(12, $synopsis->getLength());
        $this->assertEquals('Hello World!', $synopsis->getValue());
        $this->assertFalse($synopsis->hasChildren());
        $this->assertEquals([], $synopsis->getChildren());
    }
}
