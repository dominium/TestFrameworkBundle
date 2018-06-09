<?php

namespace Labudzinski\TestFrameworkBundle\Component\Layout\Tests\Unit\Extension\Theme\Stubs;

use Labudzinski\TestFrameworkBundle\Component\Layout\ImportsAwareLayoutUpdateInterface;
use Labudzinski\TestFrameworkBundle\Component\Layout\IsApplicableLayoutUpdateInterface;
use Labudzinski\TestFrameworkBundle\Component\Layout\LayoutItemInterface;
use Labudzinski\TestFrameworkBundle\Component\Layout\LayoutManipulatorInterface;
use Labudzinski\TestFrameworkBundle\Component\Layout\LayoutUpdateImportInterface;
use Labudzinski\TestFrameworkBundle\Component\Layout\LayoutUpdateInterface;
use Labudzinski\TestFrameworkBundle\Component\Layout\Model\LayoutUpdateImport;

class ImportedLayoutUpdate implements LayoutUpdateInterface, LayoutUpdateImportInterface
{
    public function getImport()
    {
    }

    public function setImport(LayoutUpdateImport $import)
    {
    }

    public function setParentUpdate(ImportsAwareLayoutUpdateInterface $parentLayoutUpdate)
    {
    }

    /**
     * {@inheritDoc}
     */
    public function updateLayout(LayoutManipulatorInterface $layoutManipulator, LayoutItemInterface $item)
    {
    }
}
