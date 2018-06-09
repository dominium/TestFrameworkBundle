<?php

namespace Labudzinski\TestFrameworkBundle\Component\Action\Tests\Unit\Action;

use Labudzinski\TestFrameworkBundle\Component\Action\Action\GetClassName;
use Labudzinski\TestFrameworkBundle\Component\ConfigExpression\ContextAccessor;
use Labudzinski\TestFrameworkBundle\Component\ConfigExpression\Tests\Unit\Fixtures\ItemStub;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\PropertyAccess\PropertyPath;

class GetClassNameTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var GetClassName
     */
    protected $action;

    /**
     * @var ContextAccessor
     */
    protected $contextAccessor;

    protected function setUp()
    {
        $this->contextAccessor = new ContextAccessor();
        $this->action = new GetClassName($this->contextAccessor);
        /** @var EventDispatcher $dispatcher */
        $dispatcher = $this->getMockBuilder('Symfony\Component\EventDispatcher\EventDispatcher')
            ->disableOriginalConstructor()
            ->getMock();
        $this->action->setDispatcher($dispatcher);
    }

    /**
     * @expectedException \Labudzinski\TestFrameworkBundle\Component\Action\Exception\InvalidParameterException
     * @expectedExceptionMessage Attribute name parameter is required
     * @throws \Labudzinski\TestFrameworkBundle\Component\Action\Exception\InvalidParameterException
     */
    public function testInitializeAttributeException()
    {
        $this->assertEquals($this->action, $this->action->initialize(['object' => new \stdClass()]));
    }

    /**
     * @expectedException \Labudzinski\TestFrameworkBundle\Component\Action\Exception\InvalidParameterException
     * @expectedExceptionMessage Object parameter is required
     * @throws \Labudzinski\TestFrameworkBundle\Component\Action\Exception\InvalidParameterException
     */
    public function testInitializeObjectException()
    {
        $this->assertEquals($this->action, $this->action->initialize([]));
    }


    /**
     * @expectedException \Labudzinski\TestFrameworkBundle\Component\Action\Exception\InvalidParameterException
     * @expectedExceptionMessage Attribute must be valid property definition.
     * @throws \Labudzinski\TestFrameworkBundle\Component\Action\Exception\InvalidParameterException
     */
    public function testInitializeAttributeWrongException()
    {
        $this->assertEquals(
            $this->action,
            $this->action->initialize(['object' => new \stdClass(), 'attribute' => 'wrong'])
        );
    }

    /**
     * @dataProvider objectDataProvider
     * @param mixed $object
     * @param string|null $class
     */
    public function testExecute($object, $class)
    {
        $options = ['object' => $object, 'attribute' => new PropertyPath('attribute')];
        $context = new ItemStub($options);

        $this->action->initialize($options);
        $this->action->execute($context);
        $this->assertEquals($class, $context->getData()['attribute']);
    }

    /**
     * @return array
     */
    public function objectDataProvider()
    {
        return [
            [new \stdClass(), 'stdClass'],
            ['string', null],
            [new PropertyPath('unknown'), null]
        ];
    }
}
