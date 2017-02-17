<?php

namespace TheIconic\Synopsis;

use PHPUnit\Framework\TestCase;
use Exception;
use TheIconic\Synopsis\AbstractSynopsis;
use TheIconic\Synopsis\ArraySynopsis;
use TheIconic\Synopsis\Factory;
use TheIconic\Synopsis\StringSynopsis;

class ArraySynopsisTest extends TestCase
{
    /**
     *
     */
    public function testProcess()
    {
        $synopsis = new ArraySynopsis();
        $synopsis->setFactory($this->getMockFactory());
        $synopsis->process([
            'a' => 'b',
            'c' => 'd',
        ], 3);

        $this->assertEquals('array', $synopsis->getType());
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