<?php

namespace TheIconic\Synopsis;

use PHPUnit\Framework\TestCase;
use Exception;
use TheIconic\Synopsis\AbstractSynopsis;
use TheIconic\Synopsis\ArraySynopsis;
use TheIconic\Synopsis\Exception\TraceSynopsis;
use TheIconic\Synopsis\Factory;
use TheIconic\Synopsis\StringSynopsis;

class ExceptionSynopsisTest extends TestCase
{
    /**
     *
     */
    public function testProcess()
    {
        $synopsis = $this->getSynopsis();

        $this->assertEquals('Exception', $synopsis->getType());
        $this->assertEquals(12, $synopsis->getLength());
        $this->assertEquals('Test Exception', $synopsis->getValue());
        $this->assertTrue($synopsis->hasChildren());

        $children = $synopsis->getChildren();
        $this->assertCount(12, $children);

        $this->assertInstanceOf(TraceSynopsis::class, $children['#0']);
        $this->assertInstanceOf(TraceSynopsis::class, $children['#11']);
    }

    /**
     * @param int $index
     * @return ExceptionSynopsis
     */
    protected function getSynopsis()
    {
        $synopsis = new ExceptionSynopsis();

        try {
            throw new Exception('Test Exception');
        } catch (Exception $e) {
            $synopsis->process($e, 3);
        }

        return $synopsis;
    }
}