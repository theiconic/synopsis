<?php

namespace TheIconic\Synopsis\Object;

use PHPUnit\Framework\TestCase;
use TheIconic\Synopsis\Factory;
use ArrayIterator;

class IteratorSynopsisTest extends TestCase
{
    /**
     *
     */
    public function testProcess()
    {
        $synopsis = new IteratorSynopsis();
        $synopsis->setFactory($this->getMockFactory());
        $synopsis->process(new ArrayIterator([
            'a' => 'b',
            'c' => 'd',
        ]), 3);

        $this->assertEquals('ArrayIterator', $synopsis->getType());
        $this->assertEquals(2, $synopsis->getLength());
        $this->assertEquals('', $synopsis->getValue());
        $this->assertTrue($synopsis->hasChildren());

        $children = $synopsis->getChildren();
        $this->assertCount(2, $children);

        $this->assertEquals(1, $children['a']);
        $this->assertEquals(2, $children['c']);
    }

    /**
     * @return Factory
     */
    protected function getMockFactory()
    {
        $factory = $this->getMockBuilder(Factory::class)
            ->setMethods(['synopsize'])
            ->getMock();

        $factory->expects($this->exactly(2))
            ->method('synopsize')
            ->withConsecutive(['b'], ['d'])
            ->willReturnOnConsecutiveCalls(1, 2);

        return $factory;
    }
}