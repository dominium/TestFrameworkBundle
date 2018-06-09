<?php

namespace Labudzinski\TestFrameworkBundle\Component\Layout\Tests\Unit\Extension\Theme\Stubs;

use Labudzinski\TestFrameworkBundle\Component\Layout\ContextInterface;
use Labudzinski\TestFrameworkBundle\Component\Layout\ImportsAwareLayoutUpdateInterface;
use Labudzinski\TestFrameworkBundle\Component\Layout\IsApplicableLayoutUpdateInterface;
use Labudzinski\TestFrameworkBundle\Component\Layout\LayoutItemInterface;
use Labudzinski\TestFrameworkBundle\Component\Layout\LayoutManipulatorInterface;
use Labudzinski\TestFrameworkBundle\Component\Layout\LayoutUpdateInterface;

class NotApplicableImportAwareLayoutUpdateStub implements
    LayoutUpdateInterface,
    ImportsAwareLayoutUpdateInterface,
    IsApplicableLayoutUpdateInterface
{
    /**
     * {@inheritdoc}
     */
    public function updateLayout(LayoutManipulatorInterface $layoutManipulator, LayoutItemInterface $item)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function getImports()
    {
        return [new ImportedLayoutUpdate()];
    }

    /**
     * {@inheritdoc}
     */
    public function isApplicable(ContextInterface $context)
    {
        return false;
    }
}
