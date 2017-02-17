<?php

namespace TheIconic\Synopsis;

use PHPUnit\Framework\TestCase;
use Exception;
use TheIconic\Synopsis\AbstractSynopsis;
use TheIconic\Synopsis\ArraySynopsis;
use TheIconic\Synopsis\Factory;
use TheIconic\Synopsis\StringSynopsis;

class NullSynopsisTest extends TestCase
{
    /**
     *
     */
    public function testProcess()
    {
        $synopsis = new NullSynopsis();
        $synopsis->process(null, 3);

        $this->assertEquals('NULL', $synopsis->getType());
        $this->assertEquals(0, $synopsis->getLength());
        $this->assertEquals(null, $synopsis->getValue());
        $this->assertFalse($synopsis->hasChildren());
        $this->assertNull($synopsis->getChildren());
    }
}