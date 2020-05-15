<?php

namespace TheIconic\Synopsis;

use PHPUnit\Framework\TestCase;
use Exception;
use TheIconic\Synopsis\AbstractSynopsis;
use TheIconic\Synopsis\ArraySynopsis;
use TheIconic\Synopsis\Factory;
use TheIconic\Synopsis\StringSynopsis;

class DoubleSynopsisTest extends TestCase
{
    /**
     *
     */
    public function testProcess()
    {
        $synopsis = new DoubleSynopsis();
        $synopsis->process(3.4, 3);

        $this->assertEquals('double', $synopsis->getType());
        $this->assertEquals(3, $synopsis->getLength());
        $this->assertEquals(3.4, $synopsis->getValue());
        $this->assertFalse($synopsis->hasChildren());
        $this->assertEquals([], $synopsis->getChildren());
    }
}
