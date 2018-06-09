<?php

namespace Labudzinski\TestFrameworkBundle\Component\Action\Tests\Unit\Condition;

use Labudzinski\TestFrameworkBundle\Component\Action\Condition\Configurable;

class ConfigurableTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    protected $assembler;

    /**
     * @var Configurable
     */
    protected $condition;

    protected function setUp()
    {
        $this->assembler = $this->getMockBuilder('Labudzinski\TestFrameworkBundle\Component\ConfigExpression\ExpressionAssembler')
            ->disableOriginalConstructor()
            ->getMock();
        $this->condition = new Configurable($this->assembler);
    }

    public function testInitialize()
    {
        $this->assertInstanceOf(
            'Labudzinski\TestFrameworkBundle\Component\ConfigExpression\Condition\AbstractCondition',
            $this->condition->initialize([])
        );
    }

    public function testEvaluate()
    {
        $options = [];
        $context = new \stdClass();
        $errors = $this->getMockForAbstractClass('Doctrine\Common\Collections\Collection');
        $realCondition = $this->getMockBuilder('Labudzinski\TestFrameworkBundle\Component\ConfigExpression\ExpressionInterface')
            ->getMockForAbstractClass();
        $realCondition->expects($this->exactly(2))
            ->method('evaluate')
            ->with($context, $errors)
            ->willReturn(true);
        $this->assembler->expects($this->once())
            ->method('assemble')
            ->with($options)
            ->willReturn($realCondition);
        $this->condition->initialize($options);
        $this->assertTrue($this->condition->evaluate($context, $errors));
        $this->assertTrue($this->condition->evaluate($context, $errors));
    }
}
