<?php

namespace Labudzinski\TestFrameworkBundle\Component\Layout\Tests\Unit\Extension\Theme;

use Labudzinski\TestFrameworkBundle\Component\Layout\Extension\Theme\Model\DependencyInitializer;
use Labudzinski\TestFrameworkBundle\Component\Layout\Extension\Theme\PathProvider\ChainPathProvider;
use Labudzinski\TestFrameworkBundle\Component\Layout\Extension\Theme\ResourceProvider\ResourceProviderInterface;
use Labudzinski\TestFrameworkBundle\Component\Layout\Extension\Theme\ThemeExtension;
use Labudzinski\TestFrameworkBundle\Component\Layout\LayoutContext;
use Labudzinski\TestFrameworkBundle\Component\Layout\LayoutItem;
use Labudzinski\TestFrameworkBundle\Component\Layout\LayoutItemInterface;
use Labudzinski\TestFrameworkBundle\Component\Layout\Loader\Driver\DriverInterface;
use Labudzinski\TestFrameworkBundle\Component\Layout\Loader\LayoutUpdateLoader;
use Labudzinski\TestFrameworkBundle\Component\Layout\RawLayoutBuilder;

class ThemeExtensionTest extends \PHPUnit_Framework_TestCase
{
    /** @var ThemeExtension */
    protected $extension;

    /** @var \PHPUnit_Framework_MockObject_MockObject|ChainPathProvider */
    protected $pathProvider;

    /** @var \PHPUnit_Framework_MockObject_MockObject|DriverInterface */
    protected $phpDriver;

    /** @var \PHPUnit_Framework_MockObject_MockObject|DriverInterface */
    protected $yamlDriver;

    /** @var \PHPUnit_Framework_MockObject_MockObject|DependencyInitializer */
    protected $dependencyInitializer;

    /** @var \PHPUnit_Framework_MockObject_MockObject|ResourceProviderInterface */
    protected $resourceProvider;

    protected function setUp()
    {
        $this->pathProvider = $this
            ->createMock('Labudzinski\TestFrameworkBundle\Component\Layout\Tests\Unit\Extension\Theme\Stubs\StubContextAwarePathProvider');
        $this->yamlDriver = $this
            ->getMockBuilder('Labudzinski\TestFrameworkBundle\Component\Layout\Loader\Driver\DriverInterface')
            ->setMethods(['load', 'getUpdateFilenamePattern'])
            ->getMock();
        $this->phpDriver = $this
            ->getMockBuilder('Labudzinski\TestFrameworkBundle\Component\Layout\Loader\Driver\DriverInterface')
            ->setMethods(['load', 'getUpdateFilenamePattern'])
            ->getMock();

        $this->dependencyInitializer = $this
            ->getMockBuilder('Labudzinski\TestFrameworkBundle\Component\Layout\Extension\Theme\Model\DependencyInitializer')
            ->disableOriginalConstructor()
            ->getMock();

        $this->resourceProvider = $this
            ->createMock('Labudzinski\TestFrameworkBundle\Component\Layout\Extension\Theme\ResourceProvider\ResourceProviderInterface');

        $loader = new LayoutUpdateLoader();
        $loader->addDriver('yml', $this->yamlDriver);
        $loader->addDriver('php', $this->phpDriver);

        $this->extension = new ThemeExtension(
            $loader,
            $this->dependencyInitializer,
            $this->pathProvider,
            $this->resourceProvider
        );
    }

    public function testGetLayoutUpdates()
    {
        $themeName = 'my-theme';
        $this->pathProvider->expects($this->once())->method('getPaths')->willReturn([$themeName]);

        $this->resourceProvider
            ->expects($this->any())
            ->method('findApplicableResources')
            ->with([$themeName])
            ->will($this->returnValue([
                'oro-default/resource1.yml',
                'oro-default/page/resource2.yml',
                'oro-default/page/resource3.php'
            ]));

        $result = $this->extension->getLayoutUpdates($this->getLayoutItem('root', $themeName));
        $this->assertEquals([], $result);
    }

    public function testThemeUpdatesFoundWithOneSkipped()
    {
        $themeName = 'oro-default';
        $this->pathProvider->expects($this->once())->method('getPaths')->willReturn([$themeName]);

        $this->resourceProvider
            ->expects($this->any())
            ->method('findApplicableResources')
            ->with([$themeName])
            ->will($this->returnValue([
                'oro-default/resource1.yml',
                'oro-default/page/resource3.php'
            ]));

        $updateMock = $this->createMock('Labudzinski\TestFrameworkBundle\Component\Layout\LayoutUpdateInterface');
        $update2Mock = $this->createMock('Labudzinski\TestFrameworkBundle\Component\Layout\LayoutUpdateInterface');

        $this->yamlDriver->expects($this->once())->method('load')
            ->with('oro-default/resource1.yml')
            ->willReturn($updateMock);
        $this->phpDriver->expects($this->once())->method('load')
            ->with('oro-default/page/resource3.php')
            ->willReturn($update2Mock);

        $result = $this->extension->getLayoutUpdates($this->getLayoutItem('root', $themeName));
        $this->assertContains($updateMock, $result);
        $this->assertContains($update2Mock, $result);
    }

    public function testShouldPassDependenciesToUpdateInstance()
    {
        $themeName = 'oro-gold';
        $update = $this->createMock('Labudzinski\TestFrameworkBundle\Component\Layout\LayoutUpdateInterface');
        $this->pathProvider->expects($this->once())->method('getPaths')->willReturn([$themeName]);

        $this->resourceProvider
            ->expects($this->any())
            ->method('findApplicableResources')
            ->with([$themeName])
            ->will($this->returnValue([
                'oro-default/resource1.yml'
            ]));

        $this->yamlDriver->expects($this->once())->method('load')->willReturn($update);

        $this->dependencyInitializer->expects($this->once())->method('initialize')->with($this->identicalTo($update));

        $this->extension->getLayoutUpdates($this->getLayoutItem('root', $themeName));
    }

    public function testShouldPassContextInContextAwareProvider()
    {
        $themeName = 'my-theme';
        $this->pathProvider->expects($this->once())->method('getPaths')->willReturn([$themeName]);

        $this->resourceProvider
            ->expects($this->any())
            ->method('findApplicableResources')
            ->with([$themeName])
            ->will($this->returnValue([
                'oro-default/resource1.yml',
                'oro-default/page/resource2.yml',
                'oro-default/page/resource3.php'
            ]));

        $this->pathProvider->expects($this->once())->method('setContext');

        $this->extension->getLayoutUpdates($this->getLayoutItem('root', $themeName));
    }

    /**
     * @param string $id
     * @param null|string $theme
     *
     * @return LayoutItemInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    protected function getLayoutItem($id, $theme = null)
    {
        $context = new LayoutContext();
        $context->set('theme', $theme);
        $layoutItem = (new LayoutItem(new RawLayoutBuilder(), $context));
        $layoutItem->initialize($id);

        return $layoutItem;
    }
}
