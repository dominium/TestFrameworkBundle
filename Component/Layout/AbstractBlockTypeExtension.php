<?php

namespace Labudzinski\TestFrameworkBundle\Component\Layout;

use Labudzinski\TestFrameworkBundle\Component\Layout\Block\OptionsResolver\OptionsResolver;
use Labudzinski\TestFrameworkBundle\Component\Layout\Block\Type\Options;

abstract class AbstractBlockTypeExtension implements BlockTypeExtensionInterface
{
    /**
     * {@inheritdoc}
     */
    public function buildBlock(BlockBuilderInterface $builder, Options $options)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function buildView(BlockView $view, BlockInterface $block, Options $options)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function finishView(BlockView $view, BlockInterface $block)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
    }
}
