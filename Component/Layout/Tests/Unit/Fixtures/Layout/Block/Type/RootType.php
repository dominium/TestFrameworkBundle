<?php

namespace Labudzinski\TestFrameworkBundle\Component\Layout\Tests\Unit\Fixtures\Layout\Block\Type;

use Labudzinski\TestFrameworkBundle\Component\Layout\Block\Type\AbstractContainerType;

class RootType extends AbstractContainerType
{
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'root';
    }
}
