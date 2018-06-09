<?php

namespace Labudzinski\TestFrameworkBundle\Component\Layout\Tests\Unit\Fixtures\Layout\Block\Type;

use Labudzinski\TestFrameworkBundle\Component\Layout\Block\Type\AbstractContainerType;

class HeaderType extends AbstractContainerType
{
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'header';
    }
}
