<?php

namespace TheIconic\Synopsis;

use PHPUnit\Framework\TestCase;
use Exception;
use TheIconic\Synopsis\AbstractSynopsis;
use TheIconic\Synopsis\ArraySynopsis;
use TheIconic\Synopsis\Factory;
use TheIconic\Synopsis\StringSynopsis;

class BooleanSynopsisTest extends TestCase
{
    /**
     *
     */
    public function testProcess()
    {
        $synopsis = new BooleanSynopsis();
        $synopsis->process(true, 3);

        $this->assertEquals('boolean', $synopsis->getType());
        $this->assertEquals(1, $synopsis->getLength());
        $this->assertEquals('true', $synopsis->getValue());
        $this->assertFalse($synopsis->hasChildren());
        $this->assertNull($synopsis->getChildren());
    }
}