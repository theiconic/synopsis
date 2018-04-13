<?php

namespace TheIconic\Synopsis;

use PHPUnit\Framework\TestCase;
use Exception;
use TheIconic\Synopsis\Exception\TraceSynopsis;

class ExceptionSynopsisTest extends TestCase
{
    /**
     *
     */
    public function testProcess()
    {
        $exception = new Exception('Test Exception');
        $synopsis = $this->getSynopsis($exception);
        $traceLines = count($exception->getTrace());
        $line = $exception->getLine();

        $this->assertEquals('Exception', $synopsis->getType());
        $this->assertEquals($traceLines, $synopsis->getLength());
        $this->assertEquals('Test Exception', $synopsis->getValue());
        $this->assertTrue($synopsis->hasChildren());

        $children = $synopsis->getChildren();
        $this->assertCount($traceLines, $children);

        foreach ($children as $child) {
            $this->assertInstanceOf(TraceSynopsis::class, $child);
        }

        $this->assertSame([
            'line' => $line,
            'file' => __FILE__,
        ], $synopsis->getDetails());
    }

    /**
     * @return ExceptionSynopsis
     */
    protected function getSynopsis($exception)
    {
        $synopsis = new ExceptionSynopsis();
        $synopsis->process($exception, 3);

        return $synopsis;
    }
}
