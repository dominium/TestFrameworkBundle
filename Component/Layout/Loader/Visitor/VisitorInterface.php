<?php

namespace Labudzinski\TestFrameworkBundle\Component\Layout\Loader\Visitor;

use Labudzinski\TestFrameworkBundle\Component\Layout\Loader\Generator\VisitContext;

interface VisitorInterface
{
    /**
     * @param VisitContext $visitContext
     */
    public function startVisit(VisitContext $visitContext);

    /**
     * @param VisitContext $visitContext
     */
    public function endVisit(VisitContext $visitContext);
}
