<?php

namespace TheIconic\Synopsis;

use PHPUnit\Framework\TestCase;
use Exception;
use TheIconic\Synopsis\AbstractSynopsis;
use TheIconic\Synopsis\ArraySynopsis;
use TheIconic\Synopsis\Factory;
use TheIconic\Synopsis\StringSynopsis;

class ObjectSynopsisTest extends TestCase
{
    /**
     * @var string
     */
    public $publicProp = 'a';

    /**
     * @var string
     */
    protected $protectedProp = 'b';

    /**
     * @var string
     */
    private $privateProp = 'c';

    /**
     *
     */
    public function testProcess()
    {
        $object = new self();

        $synopsis = new ObjectSynopsis();
        $synopsis->setFactory($this->getMockFactory());
        $synopsis->process($object, 3);

        $this->assertEquals(__CLASS__, $synopsis->getType());
        $this->assertEquals(1, $synopsis->getLength());
        $this->assertEquals('', $synopsis->getValue());
        $this->assertTrue($synopsis->hasChildren());

        $children = $synopsis->getChildren();
        $this->assertCount(1, $children);

        $this->assertEquals(1, $children['publicProp']);
    }

    /**
     * @return Factory
     */
    protected function getMockFactory()
    {
        $factory = $this->getMockBuilder(Factory::class)
            ->setMethods(['synopsize'])
            ->getMock();

        $factory->expects($this->exactly(1))
            ->method('synopsize')
            ->with('a', 3)
            ->willReturn(1);

        return $factory;
    }
}