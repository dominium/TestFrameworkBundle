<?php

namespace Labudzinski\TestFrameworkBundle\Component\Layout\Extension\Theme\Visitor;

use Labudzinski\TestFrameworkBundle\Component\Layout\ContextInterface;

interface VisitorInterface
{
    /**
     * @param array $updates
     * @param ContextInterface $context
     */
    public function walkUpdates(array &$updates, ContextInterface $context);
}
