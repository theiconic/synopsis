<?php

namespace TheIconic\Synopsis;

use PHPUnit\Framework\TestCase;
use Exception;
use TheIconic\Synopsis\AbstractSynopsis;
use TheIconic\Synopsis\ArraySynopsis;
use TheIconic\Synopsis\Factory;
use TheIconic\Synopsis\StringSynopsis;

class IntegerSynopsisTest extends TestCase
{
    /**
     *
     */
    public function testProcess()
    {
        $synopsis = new IntegerSynopsis();
        $synopsis->process(3, 3);

        $this->assertEquals('integer', $synopsis->getType());
        $this->assertEquals(1, $synopsis->getLength());
        $this->assertEquals(3, $synopsis->getValue());
        $this->assertFalse($synopsis->hasChildren());
        $this->assertEquals([], $synopsis->getChildren());
    }
}
