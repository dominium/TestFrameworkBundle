<?php

namespace Labudzinski\TestFrameworkBundle\Component\Layout\Tests\Unit;

use Labudzinski\TestFrameworkBundle\Component\Layout\BlockBuilder;
use Labudzinski\TestFrameworkBundle\Component\Layout\BlockTypeHelperInterface;
use Labudzinski\TestFrameworkBundle\Component\Layout\LayoutContext;
use Labudzinski\TestFrameworkBundle\Component\Layout\LayoutManipulatorInterface;
use Labudzinski\TestFrameworkBundle\Component\Layout\LayoutRegistryInterface;
use Labudzinski\TestFrameworkBundle\Component\Layout\RawLayout;

class BlockBuilderTest extends \PHPUnit_Framework_TestCase
{
    /** @var RawLayout */
    protected $rawLayout;

    /** @var BlockTypeHelperInterface|\PHPUnit_Framework_MockObject_MockObject */
    protected $typeHelper;

    /** @var LayoutContext */
    protected $context;

    /** @var LayoutManipulatorInterface|\PHPUnit_Framework_MockObject_MockObject */
    protected $layoutManipulator;

    /** @var BlockBuilder */
    protected $blockBuilder;

    /** @var LayoutRegistryInterface|\PHPUnit_Framework_MockObject_MockObject */
    protected $registry;

    protected function setUp()
    {
        $this->rawLayout         = new RawLayout();
        $this->typeHelper        = $this->createMock('Labudzinski\TestFrameworkBundle\Component\Layout\BlockTypeHelperInterface');
        $this->context           = new LayoutContext();
        $this->layoutManipulator = $this->createMock('Labudzinski\TestFrameworkBundle\Component\Layout\LayoutManipulatorInterface');
        $this->registry          = $this->createMock('Labudzinski\TestFrameworkBundle\Component\Layout\LayoutRegistryInterface');

        $this->blockBuilder      = new BlockBuilder(
            $this->layoutManipulator,
            $this->rawLayout,
            $this->typeHelper,
            $this->context
        );
    }

    public function testGetTypeHelper()
    {
        $this->assertSame($this->typeHelper, $this->blockBuilder->getTypeHelper());
    }

    public function testGetContext()
    {
        $this->assertSame($this->context, $this->blockBuilder->getContext());
    }

    public function testGetLayoutManipulator()
    {
        $this->assertSame($this->layoutManipulator, $this->blockBuilder->getLayoutManipulator());
    }

    public function testInitialize()
    {
        $id = 'test_id';

        $this->blockBuilder->initialize($id);

        $this->assertEquals($id, $this->blockBuilder->getId());
    }

    public function testGetTypeName()
    {
        $id   = 'test_id';
        $name = 'test_name';

        $this->rawLayout->add($id, null, $name);

        $this->blockBuilder->initialize($id);

        $this->assertEquals($name, $this->blockBuilder->getTypeName());
    }

    public function testGetTypeNameWhenBlockTypeIsAddedAsObject()
    {
        $id   = 'test_id';
        $name = 'test_name';

        $type = $this->createMock('Labudzinski\TestFrameworkBundle\Component\Layout\BlockTypeInterface');
        $type->expects($this->once())
            ->method('getName')
            ->will($this->returnValue($name));

        $this->rawLayout->add($id, null, $type);

        $this->blockBuilder->initialize($id);

        $this->assertEquals($name, $this->blockBuilder->getTypeName());
    }
}
