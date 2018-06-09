<?php

namespace Labudzinski\TestFrameworkBundle\Component\Layout\Tests\Unit;

use Labudzinski\TestFrameworkBundle\Component\Layout\Block\Type\Options;
use Labudzinski\TestFrameworkBundle\Component\Layout\BlockOptionsResolver;
use Labudzinski\TestFrameworkBundle\Component\Layout\BlockTypeInterface;
use Labudzinski\TestFrameworkBundle\Component\Layout\BlockView;
use Labudzinski\TestFrameworkBundle\Component\Layout\Extension\ExtensionInterface;
use Labudzinski\TestFrameworkBundle\Component\Layout\LayoutContext;
use Labudzinski\TestFrameworkBundle\Component\Layout\LayoutFactoryBuilderInterface;
use Labudzinski\TestFrameworkBundle\Component\Layout\LayoutFactoryInterface;
use Labudzinski\TestFrameworkBundle\Component\Layout\Layouts;

/**
 * The base test case that helps testing block types
 */
abstract class BaseBlockTypeTestCase extends LayoutTestCase
{
    /** @var LayoutContext */
    protected $context;

    /** @var LayoutFactoryInterface */
    protected $layoutFactory;

    protected function setUp()
    {
        $this->context = new LayoutContext();

        $layoutFactoryBuilder = Layouts::createLayoutFactoryBuilder();
        $this->initializeLayoutFactoryBuilder($layoutFactoryBuilder);
        foreach ($this->getExtensions() as $extension) {
            $layoutFactoryBuilder->addExtension($extension);
        }
        $this->layoutFactory = $layoutFactoryBuilder->getLayoutFactory();
    }

    /**
     * @param LayoutFactoryBuilderInterface $layoutFactoryBuilder
     */
    protected function initializeLayoutFactoryBuilder(LayoutFactoryBuilderInterface $layoutFactoryBuilder)
    {
        $layoutFactoryBuilder->addRenderer(
            'test',
            $this->createMock('Labudzinski\TestFrameworkBundle\Component\Layout\LayoutRendererInterface')
        );
    }

    /**
     * @return ExtensionInterface[]
     */
    protected function getExtensions()
    {
        return [];
    }

    /**
     * Returns a block type by its name
     *
     * @param string $blockType
     *
     * @return BlockTypeInterface
     */
    protected function getBlockType($blockType)
    {
        return $this->layoutFactory->getType($blockType);
    }

    /**
     * Asks the given block type to resolve options
     *
     * @param string|BlockTypeInterface $blockType
     * @param array                     $options
     *
     * @return array The resolved options
     */
    protected function resolveOptions($blockType, array $options)
    {
        $blockOptionsResolver = new BlockOptionsResolver($this->layoutFactory->getRegistry());

        return $blockOptionsResolver->resolveOptions($blockType, $options);
    }

    /**
     * Creates a view for the given block type
     *
     * @param string|BlockTypeInterface $blockType
     * @param array                     $options
     *
     * @return BlockView
     */
    protected function getBlockView($blockType, array $options = [])
    {
        $layoutBuilder = $this->layoutFactory->createLayoutBuilder();
        $layoutBuilder->add(
            ($blockType instanceof BlockTypeInterface ? $blockType->getName() : $blockType) . '_id',
            null,
            $blockType,
            $options
        );
        $layout = $layoutBuilder->getLayout($this->context);

        return $layout->getView();
    }

    /**
     * Creates a builder which can be used to build block hierarchy
     *
     * @param string $blockType
     * @param array  $options
     * @param string $id
     *
     * @return TestBlockBuilder
     */
    protected function getBlockBuilder($blockType, array $options = [], $id = null)
    {
        return new TestBlockBuilder(
            $this->layoutFactory->createLayoutBuilder(),
            $this->context,
            $id ?: $blockType . '_id',
            $blockType,
            $options
        );
    }
}
