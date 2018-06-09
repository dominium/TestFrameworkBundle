<?php

namespace Labudzinski\TestFrameworkBundle\Component\ConfigExpression\Tests\Unit\Extension\DependencyInjection;

use Labudzinski\TestFrameworkBundle\Component\ConfigExpression\Extension\DependencyInjection\DependencyInjectionExtension;

class DependencyInjectionExtensionTest extends \PHPUnit_Framework_TestCase
{
    /** @var \PHPUnit_Framework_MockObject_MockObject */
    protected $container;

    /** @var DependencyInjectionExtension */
    protected $extension;

    /** @var  array */
    protected $serviceIds;

    protected function setUp()
    {
        $this->serviceIds = ['test' => 'expression_service'];
        $this->container = $this->createMock('Symfony\Component\DependencyInjection\ContainerInterface');
        $this->extension = new DependencyInjectionExtension(
            $this->container,
            $this->serviceIds
        );
    }

    public function testHasExpression()
    {
        $this->assertTrue($this->extension->hasExpression('test'));
        $this->assertFalse($this->extension->hasExpression('unknown'));
    }

    public function testGetExpression()
    {
        $expr = $this->createMock('Labudzinski\TestFrameworkBundle\Component\ConfigExpression\ExpressionInterface');

        $this->container->expects($this->once())
            ->method('get')
            ->with('expression_service')
            ->will($this->returnValue($expr));

        $this->assertSame($expr, $this->extension->getExpression('test'));
    }

    /**
     * @expectedException \Labudzinski\TestFrameworkBundle\Component\ConfigExpression\Exception\InvalidArgumentException
     * @expectedExceptionMessage The expression "unknown" is not registered with the service container.
     */
    public function testGetUnknownExpression()
    {
        $this->extension->getExpression('unknown');
    }

    public function testGetServiceIds()
    {
        $this->assertSame($this->serviceIds, $this->extension->getServiceIds());
    }
}
