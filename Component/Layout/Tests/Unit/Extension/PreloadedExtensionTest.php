<?php

namespace Labudzinski\TestFrameworkBundle\Component\Layout\Tests\Unit\Extension;

use Labudzinski\TestFrameworkBundle\Component\Layout\Extension\PreloadedExtension;

class PreloadedExtensionTest extends \PHPUnit_Framework_TestCase
{
    public function testTypes()
    {
        $name = 'test';
        $type = $this->createMock('Labudzinski\TestFrameworkBundle\Component\Layout\BlockTypeInterface');

        $extension = new PreloadedExtension(
            [
                $name => $type
            ]
        );

        $this->assertTrue($extension->hasType($name));
        $this->assertFalse($extension->hasType('unknown'));

        $this->assertSame($type, $extension->getType($name));
    }

    /**
     * @expectedException \Labudzinski\TestFrameworkBundle\Component\Layout\Exception\InvalidArgumentException
     * @expectedExceptionMessage The type "unknown" can not be loaded by this extension.
     */
    public function testGetUnknownType()
    {
        $extension = new PreloadedExtension([]);

        $extension->getType('unknown');
    }

    public function testBlockTypeExtensions()
    {
        $name          = 'test';
        $typeExtension = $this->createMock('Labudzinski\TestFrameworkBundle\Component\Layout\BlockTypeExtensionInterface');

        $extension = new PreloadedExtension(
            [],
            [
                $name => [$typeExtension]
            ]
        );

        $this->assertTrue($extension->hasTypeExtensions($name));
        $this->assertFalse($extension->hasTypeExtensions('unknown'));

        $this->assertCount(1, $extension->getTypeExtensions($name));
        $this->assertSame($typeExtension, $extension->getTypeExtensions($name)[0]);

        $this->assertSame([], $extension->getTypeExtensions('unknown'));
    }

    public function testGetLayoutUpdates()
    {
        $id           = 'test';
        $layoutUpdate = $this->createMock('Labudzinski\TestFrameworkBundle\Component\Layout\LayoutUpdateInterface');

        $extension = new PreloadedExtension(
            [],
            [],
            [
                $id => [$layoutUpdate]
            ]
        );

        $layoutItem = $this->createMock('Labudzinski\TestFrameworkBundle\Component\Layout\LayoutItemInterface');
        $layoutItem->expects($this->once())->method('getId')->willReturn($id);
        $layoutItemUnknown = $this->createMock('Labudzinski\TestFrameworkBundle\Component\Layout\LayoutItemInterface');
        $layoutItemUnknown->expects($this->once())->method('getId')->willReturn('unknown');
        $layoutItemAlias = $this->createMock('Labudzinski\TestFrameworkBundle\Component\Layout\LayoutItemInterface');
        $layoutItemAlias->expects($this->never())->method('getId');
        $layoutItemAlias->expects($this->once())->method('getAlias')->willReturn($id);

        $layoutUpdates = $extension->getLayoutUpdates($layoutItem);
        $this->assertCount(1, $layoutUpdates);
        $this->assertSame($layoutUpdate, $layoutUpdates[0]);

        $this->assertSame([], $extension->getLayoutUpdates($layoutItemUnknown));

        $layoutUpdates = $extension->getLayoutUpdates($layoutItemAlias);
        $this->assertCount(1, $layoutUpdates);
        $this->assertSame($layoutUpdate, $layoutUpdates[0]);
    }

    public function testHasLayoutUpdates()
    {
        $id           = 'test';
        $layoutUpdate = $this->createMock('Labudzinski\TestFrameworkBundle\Component\Layout\LayoutUpdateInterface');

        $extension = new PreloadedExtension(
            [],
            [],
            [
                $id => [$layoutUpdate]
            ]
        );

        $layoutItem = $this->createMock('Labudzinski\TestFrameworkBundle\Component\Layout\LayoutItemInterface');
        $layoutItem->expects($this->once())->method('getId')->willReturn($id);
        $layoutItemUnknown = $this->createMock('Labudzinski\TestFrameworkBundle\Component\Layout\LayoutItemInterface');
        $layoutItemUnknown->expects($this->once())->method('getId')->willReturn('unknown');
        $layoutItemAlias = $this->createMock('Labudzinski\TestFrameworkBundle\Component\Layout\LayoutItemInterface');
        $layoutItemAlias->expects($this->never())->method('getId');
        $layoutItemAlias->expects($this->once())->method('getAlias')->willReturn($id);

        $this->assertTrue($extension->hasLayoutUpdates($layoutItem));
        $this->assertFalse($extension->hasLayoutUpdates($layoutItemUnknown));
        $this->assertTrue($extension->hasLayoutUpdates($layoutItemAlias));
    }

    public function testContextConfigurators()
    {
        $configurator = $this->createMock('Labudzinski\TestFrameworkBundle\Component\Layout\ContextConfiguratorInterface');

        $extension = new PreloadedExtension(
            [],
            [],
            [],
            [$configurator]
        );

        $this->assertTrue($extension->hasContextConfigurators());

        $result = $extension->getContextConfigurators();
        $this->assertCount(1, $result);
        $this->assertSame($configurator, $result[0]);
    }

    public function testContextConfiguratorsWheNoAnyRegistered()
    {
        $extension = new PreloadedExtension([]);

        $this->assertFalse($extension->hasContextConfigurators());
        $this->assertSame([], $extension->getContextConfigurators());
    }

    public function testDataProviders()
    {
        $name         = 'test';
        $dataProvider = $this->createMock(\stdClass::class);

        $extension = new PreloadedExtension(
            [],
            [],
            [],
            [],
            [
                $name => $dataProvider
            ]
        );

        $this->assertTrue($extension->hasDataProvider($name));
        $this->assertFalse($extension->hasDataProvider('unknown'));

        $this->assertSame($dataProvider, $extension->getDataProvider($name));
    }

    /**
     * @expectedException \Labudzinski\TestFrameworkBundle\Component\Layout\Exception\InvalidArgumentException
     * @expectedExceptionMessage The data provider "unknown" can not be loaded by this extension.
     */
    public function testGetUnknownDataProvider()
    {
        $extension = new PreloadedExtension([], [], [], [], []);

        $extension->getDataProvider('unknown');
    }

    /**
     * @expectedException \Labudzinski\TestFrameworkBundle\Component\Layout\Exception\InvalidArgumentException
     * @expectedExceptionMessage Keys of $types array must be strings.
     */
    public function testConstructWithInvalidKeysForBlockTypes()
    {
        new PreloadedExtension(
            [
                'test' => $this->createMock('Labudzinski\TestFrameworkBundle\Component\Layout\BlockTypeInterface'),
                $this->createMock('Labudzinski\TestFrameworkBundle\Component\Layout\BlockTypeInterface')
            ]
        );
    }

    /**
     * @expectedException \Labudzinski\TestFrameworkBundle\Component\Layout\Exception\InvalidArgumentException
     * @expectedExceptionMessage Each item of $types array must be BlockTypeInterface.
     */
    public function testConstructWithInvalidBlockTypes()
    {
        new PreloadedExtension(
            [
                'test1' => $this->createMock('Labudzinski\TestFrameworkBundle\Component\Layout\BlockTypeInterface'),
                'test2' => new \stdClass()
            ]
        );
    }

    /**
     * @expectedException \Labudzinski\TestFrameworkBundle\Component\Layout\Exception\InvalidArgumentException
     * @expectedExceptionMessage Keys of $typeExtensions array must be strings.
     */
    public function testConstructWithInvalidKeysForBlockTypeExtensions()
    {
        new PreloadedExtension(
            [],
            [
                'test' => [$this->createMock('Labudzinski\TestFrameworkBundle\Component\Layout\BlockTypeExtensionInterface')],
                [$this->createMock('Labudzinski\TestFrameworkBundle\Component\Layout\BlockTypeExtensionInterface')]
            ]
        );
    }

    /**
     * @expectedException \Labudzinski\TestFrameworkBundle\Component\Layout\Exception\InvalidArgumentException
     * @expectedExceptionMessage Each item of $typeExtensions[] array must be BlockTypeExtensionInterface.
     */
    public function testConstructWithInvalidBlockTypeExtensions()
    {
        new PreloadedExtension(
            [],
            [
                'test1' => [$this->createMock('Labudzinski\TestFrameworkBundle\Component\Layout\BlockTypeExtensionInterface')],
                'test2' => [new \stdClass()]
            ]
        );
    }

    /**
     * @expectedException \Labudzinski\TestFrameworkBundle\Component\Layout\Exception\InvalidArgumentException
     * @expectedExceptionMessage Each item of $typeExtensions array must be array of BlockTypeExtensionInterface.
     */
    public function testConstructWithSingleBlockTypeExtensions()
    {
        new PreloadedExtension(
            [],
            [
                'test' => $this->createMock('Labudzinski\TestFrameworkBundle\Component\Layout\BlockTypeExtensionInterface')
            ]
        );
    }

    /**
     * @expectedException \Labudzinski\TestFrameworkBundle\Component\Layout\Exception\InvalidArgumentException
     * @expectedExceptionMessage Keys of $layoutUpdates array must be strings.
     */
    public function testConstructWithInvalidKeysForLayoutUpdates()
    {
        new PreloadedExtension(
            [],
            [],
            [
                'test' => [$this->createMock('Labudzinski\TestFrameworkBundle\Component\Layout\LayoutUpdateInterface')],
                [$this->createMock('Labudzinski\TestFrameworkBundle\Component\Layout\LayoutUpdateInterface')]
            ]
        );
    }

    /**
     * @expectedException \Labudzinski\TestFrameworkBundle\Component\Layout\Exception\InvalidArgumentException
     * @expectedExceptionMessage Each item of $layoutUpdates[] array must be LayoutUpdateInterface.
     */
    public function testConstructWithInvalidLayoutUpdates()
    {
        new PreloadedExtension(
            [],
            [],
            [
                'test1' => [$this->createMock('Labudzinski\TestFrameworkBundle\Component\Layout\LayoutUpdateInterface')],
                'test2' => [new \stdClass()]
            ]
        );
    }

    /**
     * @expectedException \Labudzinski\TestFrameworkBundle\Component\Layout\Exception\InvalidArgumentException
     * @expectedExceptionMessage Each item of $layoutUpdates array must be array of LayoutUpdateInterface.
     */
    public function testConstructWithSingleLayoutUpdates()
    {
        new PreloadedExtension(
            [],
            [],
            [
                'test' => $this->createMock('Labudzinski\TestFrameworkBundle\Component\Layout\LayoutUpdateInterface')
            ]
        );
    }

    /**
     * @expectedException \Labudzinski\TestFrameworkBundle\Component\Layout\Exception\InvalidArgumentException
     * @expectedExceptionMessage Each item of $contextConfigurators array must be ContextConfiguratorInterface.
     */
    public function testConstructWithInvalidContextConfiguratorType()
    {
        new PreloadedExtension(
            [],
            [],
            [],
            [
                $this->createMock('Labudzinski\TestFrameworkBundle\Component\Layout\ContextConfiguratorInterface'),
                new \stdClass()
            ]
        );
    }

    /**
     * @expectedException \Labudzinski\TestFrameworkBundle\Component\Layout\Exception\InvalidArgumentException
     * @expectedExceptionMessage Keys of $dataProviders array must be strings.
     */
    public function testConstructWithInvalidKeysForDataProviders()
    {
        new PreloadedExtension(
            [],
            [],
            [],
            [],
            [
                'test' => $this->createMock(\stdClass::class),
                $this->createMock(\stdClass::class)
            ]
        );
    }
}
