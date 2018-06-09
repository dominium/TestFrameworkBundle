<?php

namespace Labudzinski\TestFrameworkBundle\Component\Layout\Loader\Generator;

use Labudzinski\TestFrameworkBundle\Component\Layout\Loader\Visitor\VisitorCollection;

interface ConfigLayoutUpdateGeneratorExtensionInterface
{
    /**
     * Scans the given GeneratorData and add appropriate visitor to the collection of visitors.
     *
     * @param GeneratorData $data
     * @param VisitorCollection $visitorCollection
     */
    public function prepare(GeneratorData $data, VisitorCollection $visitorCollection);
}
