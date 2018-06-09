<?php

namespace Labudzinski\TestFrameworkBundle\Component\Layout\Tests\Unit\Fixtures\Layout\Block\Type;

use Labudzinski\TestFrameworkBundle\Component\Layout\Block\OptionsResolver\OptionsResolver;
use Labudzinski\TestFrameworkBundle\Component\Layout\Block\Type\AbstractType;
use Labudzinski\TestFrameworkBundle\Component\Layout\Block\Type\Options;
use Labudzinski\TestFrameworkBundle\Component\Layout\BlockInterface;
use Labudzinski\TestFrameworkBundle\Component\Layout\BlockView;

class LogoType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'title' => ''
            ]
        );
    }

    /**
     * {@inheritdoc}
     */
    public function buildView(BlockView $view, BlockInterface $block, Options $options)
    {
        $view->vars['title'] = $options['title'];
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'logo';
    }
}
