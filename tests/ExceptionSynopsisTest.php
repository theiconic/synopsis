<?php

namespace TheIconic\Synopsis;

use PHPUnit\Framework\TestCase;
use Exception;
use TheIconic\Synopsis\Exception\TraceSynopsis;

class ExceptionSynopsisTest extends TestCase
{
    /**
     * @var int
     */
    protected $line;

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

        $this->assertSame([
            'line' => $this->line,
            'file' => __FILE__,
        ], $synopsis->getDetails());
    }

    /**
     * @return ExceptionSynopsis
     */
    protected function getSynopsis()
    {
        $synopsis = new ExceptionSynopsis();

        try {
            $this->line = __LINE__ + 1;
            throw new Exception('Test Exception');
        } catch (Exception $e) {
            $synopsis->process($e, 3);
        }

        return $synopsis;
    }
}