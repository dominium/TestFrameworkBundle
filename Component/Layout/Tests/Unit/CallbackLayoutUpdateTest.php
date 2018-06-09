<?php

namespace Labudzinski\TestFrameworkBundle\Component\Layout\Tests\Unit;

use Labudzinski\TestFrameworkBundle\Component\Layout\CallbackLayoutUpdate;
use Labudzinski\TestFrameworkBundle\Component\Layout\LayoutItemInterface;
use Labudzinski\TestFrameworkBundle\Component\Layout\LayoutManipulatorInterface;

class CallbackLayoutUpdateTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @expectedException \Labudzinski\TestFrameworkBundle\Component\Layout\Exception\UnexpectedTypeException
     * @expectedExceptionMessage Expected argument of type "callable", "integer" given.
     */
    public function testInvalidCallbackType()
    {
        new CallbackLayoutUpdate(123);
    }

    public function testCallbackCall()
    {
        $layoutUpdate = new CallbackLayoutUpdate([$this, 'callbackFunction']);

        $layoutManipulator = $this->createMock('Labudzinski\TestFrameworkBundle\Component\Layout\LayoutManipulatorInterface');
        $item              = $this->createMock('Labudzinski\TestFrameworkBundle\Component\Layout\LayoutItemInterface');

        $layoutManipulator->expects($this->once())
            ->method('add')
            ->with('id', 'parentId', 'blockType');
        $item->expects($this->once())
            ->method('getId')
            ->will($this->returnValue('parentId'));
        $item->expects($this->once())
            ->method('getTypeName')
            ->will($this->returnValue('blockType'));

        $layoutUpdate->updateLayout($layoutManipulator, $item);
    }

    /**
     * @param LayoutManipulatorInterface $layoutManipulator
     * @param LayoutItemInterface        $item
     */
    public function callbackFunction(LayoutManipulatorInterface $layoutManipulator, LayoutItemInterface $item)
    {
        $layoutManipulator->add('id', $item->getId(), $item->getTypeName());
    }
}
