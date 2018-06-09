<?php

namespace Labudzinski\TestFrameworkBundle\Component\ConfigExpression\Tests\Unit\Extension;

use Labudzinski\TestFrameworkBundle\Component\ConfigExpression\Tests\Unit\Fixtures\AbstractExtensionStub;

class AbstractExtensionTest extends \PHPUnit_Framework_TestCase
{
    public function testHasExpression()
    {
        $extension = $this->getAbstractExtension();
        $this->assertTrue($extension->hasExpression('test'));
        $this->assertFalse($extension->hasExpression('unknown'));
    }

    public function testGetExpression()
    {
        $extension = $this->getAbstractExtension();
        $this->assertInstanceOf(
            'Labudzinski\TestFrameworkBundle\Component\ConfigExpression\ExpressionInterface',
            $extension->getExpression('test')
        );
    }

    /**
     * @expectedException \Labudzinski\TestFrameworkBundle\Component\ConfigExpression\Exception\InvalidArgumentException
     * @expectedExceptionMessage The expression "unknown" can not be loaded by this extension.
     */
    public function testGetUnknownExpression()
    {
        $extension = $this->getAbstractExtension();
        $extension->getExpression('unknown');
    }

    // @codingStandardsIgnoreStart
    /**
     * @expectedException \Labudzinski\TestFrameworkBundle\Component\ConfigExpression\Exception\UnexpectedTypeException
     * @expectedExceptionMessage Expected argument of type "Labudzinski\TestFrameworkBundle\Component\ConfigExpression\ExpressionInterface", "integer" given.
     */
    // @codingStandardsIgnoreEnd
    public function testLoadInvalidExpressions()
    {
        $extension = new AbstractExtensionStub([123]);
        $extension->hasExpression('test');
    }

    protected function getAbstractExtension()
    {
        $expr = $this->createMock('Labudzinski\TestFrameworkBundle\Component\ConfigExpression\ExpressionInterface');
        $expr->expects($this->any())
            ->method('getName')
            ->will($this->returnValue('test'));

        return new AbstractExtensionStub([$expr]);
    }
}
