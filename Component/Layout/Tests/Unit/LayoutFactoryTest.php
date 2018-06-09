<?php

namespace Labudzinski\TestFrameworkBundle\Component\Layout\Tests\Unit;

use Labudzinski\TestFrameworkBundle\Component\Layout\ExpressionLanguage\ExpressionProcessor;
use Labudzinski\TestFrameworkBundle\Component\Layout\LayoutFactory;

class LayoutFactoryTest extends \PHPUnit_Framework_TestCase
{
    /** @var \PHPUnit_Framework_MockObject_MockObject */
    protected $registry;

    /** @var \PHPUnit_Framework_MockObject_MockObject */
    protected $rendererRegistry;

    /** @var ExpressionProcessor|\PHPUnit_Framework_MockObject_MockObject */
    protected $expressionProcessor;

    /** @var LayoutFactory */
    protected $layoutFactory;

    protected function setUp()
    {
        $this->registry            = $this->createMock('Labudzinski\TestFrameworkBundle\Component\Layout\LayoutRegistryInterface');
        $this->rendererRegistry    = $this->createMock('Labudzinski\TestFrameworkBundle\Component\Layout\LayoutRendererRegistryInterface');
        $this->expressionProcessor = $this
            ->getMockBuilder('Labudzinski\TestFrameworkBundle\Component\Layout\ExpressionLanguage\ExpressionProcessor')
            ->disableOriginalConstructor()
            ->getMock();
        $this->layoutFactory       = new LayoutFactory(
            $this->registry,
            $this->rendererRegistry,
            $this->expressionProcessor
        );
    }

    public function testGetRegistry()
    {
        $this->assertSame($this->registry, $this->layoutFactory->getRegistry());
    }

    public function testGetRendererRegistry()
    {
        $this->assertSame($this->rendererRegistry, $this->layoutFactory->getRendererRegistry());
    }

    public function testGetType()
    {
        $name = 'test';
        $type = $this->createMock('Labudzinski\TestFrameworkBundle\Component\Layout\BlockTypeInterface');

        $this->registry->expects($this->once())
            ->method('getType')
            ->with($name)
            ->will($this->returnValue($type));

        $this->assertSame($type, $this->layoutFactory->getType($name));
    }

    public function testCreateRawLayoutBuilder()
    {
        $this->assertInstanceOf(
            'Labudzinski\TestFrameworkBundle\Component\Layout\RawLayoutBuilderInterface',
            $this->layoutFactory->createRawLayoutBuilder()
        );
    }

    public function testCreateLayoutManipulator()
    {
        $rawLayoutBuilder = $this->createMock('Labudzinski\TestFrameworkBundle\Component\Layout\RawLayoutBuilderInterface');

        $this->assertInstanceOf(
            'Labudzinski\TestFrameworkBundle\Component\Layout\DeferredLayoutManipulatorInterface',
            $this->layoutFactory->createLayoutManipulator($rawLayoutBuilder)
        );
    }

    public function testCreateBlockFactory()
    {
        $layoutManipulator = $this->createMock('Labudzinski\TestFrameworkBundle\Component\Layout\DeferredLayoutManipulatorInterface');

        $this->assertInstanceOf(
            'Labudzinski\TestFrameworkBundle\Component\Layout\BlockFactoryInterface',
            $this->layoutFactory->createBlockFactory($layoutManipulator)
        );
    }

    public function testCreateLayoutBuilder()
    {
        $this->assertInstanceOf(
            'Labudzinski\TestFrameworkBundle\Component\Layout\LayoutBuilderInterface',
            $this->layoutFactory->createLayoutBuilder()
        );
    }
}
