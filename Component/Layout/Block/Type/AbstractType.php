<?php

namespace Labudzinski\TestFrameworkBundle\Component\Layout\Block\Type;

use Labudzinski\TestFrameworkBundle\Component\Layout\Block\OptionsResolver\OptionsResolver;
use Labudzinski\TestFrameworkBundle\Component\Layout\BlockBuilderInterface;
use Labudzinski\TestFrameworkBundle\Component\Layout\BlockInterface;
use Labudzinski\TestFrameworkBundle\Component\Layout\BlockTypeInterface;
use Labudzinski\TestFrameworkBundle\Component\Layout\BlockView;

abstract class AbstractType implements BlockTypeInterface
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

    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return BaseType::NAME;
    }
}
