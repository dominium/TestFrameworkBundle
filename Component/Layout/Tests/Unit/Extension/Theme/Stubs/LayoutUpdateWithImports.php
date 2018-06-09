<?php

namespace Labudzinski\TestFrameworkBundle\Component\Layout\Tests\Unit\Extension\Theme\Stubs;

use Labudzinski\TestFrameworkBundle\Component\Layout\ImportsAwareLayoutUpdateInterface;
use Labudzinski\TestFrameworkBundle\Component\Layout\LayoutItemInterface;
use Labudzinski\TestFrameworkBundle\Component\Layout\LayoutManipulatorInterface;
use Labudzinski\TestFrameworkBundle\Component\Layout\LayoutUpdateInterface;

class LayoutUpdateWithImports implements LayoutUpdateInterface, ImportsAwareLayoutUpdateInterface
{
    /**
     * @return array
     */
    public function getImports()
    {
    }

    /**
     * {@inheritdoc}
     */
    public function updateLayout(LayoutManipulatorInterface $layoutManipulator, LayoutItemInterface $item)
    {
    }
}
