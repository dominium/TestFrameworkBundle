<?php

namespace Labudzinski\TestFrameworkBundle\Component\Layout\Block\Type;

class ContainerType extends AbstractType
{
    const NAME = 'container';

    /**
    * {@inheritdoc}
    */
    public function getName()
    {
        return self::NAME;
    }
}
