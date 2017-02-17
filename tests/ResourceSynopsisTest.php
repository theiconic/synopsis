<?php

namespace TheIconic\Synopsis;

use PHPUnit\Framework\TestCase;
use Exception;
use TheIconic\Synopsis\AbstractSynopsis;
use TheIconic\Synopsis\ArraySynopsis;
use TheIconic\Synopsis\Factory;
use TheIconic\Synopsis\StringSynopsis;

class ResourceSynopsisTest extends TestCase
{
    /**
     *
     */
    public function testProcess()
    {
        $synopsis = new ResourceSynopsis();
        $synopsis->process(STDIN, 3);

        $this->assertEquals('resource', $synopsis->getType());
        $this->assertEquals(0, $synopsis->getLength());
        $this->assertEquals('', $synopsis->getValue());
        $this->assertFalse($synopsis->hasChildren());
        $this->assertNull($synopsis->getChildren());
    }
}