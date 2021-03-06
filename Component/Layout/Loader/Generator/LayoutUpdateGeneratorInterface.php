<?php

namespace Labudzinski\TestFrameworkBundle\Component\Layout\Loader\Generator;

use Labudzinski\TestFrameworkBundle\Component\Layout\Loader\Visitor\VisitorCollection;

interface LayoutUpdateGeneratorInterface
{
    const UPDATE_METHOD_NAME = 'updateLayout';

    const PARAM_LAYOUT_MANIPULATOR = 'layoutManipulator';
    const PARAM_LAYOUT_ITEM        = 'item';

    /**
     * Generates valid PHP class that is instance of "Labudzinski\TestFrameworkBundle\Component\Layout\LayoutUpdateInterface" based on given data.
     *
     * @param string            $className Class name for newly generated PHP source
     * @param GeneratorData     $data      Data consist actions which should be generated as PHP code
     * @param VisitorCollection $visitorCollection
     *
     * @return string
     */
    public function generate($className, GeneratorData $data, VisitorCollection $visitorCollection = null);

    /**
     * @return VisitorCollection
     */
    public function getVisitorCollection();
}
