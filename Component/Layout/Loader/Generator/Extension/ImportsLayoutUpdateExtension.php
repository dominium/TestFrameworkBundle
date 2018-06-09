<?php

namespace Labudzinski\TestFrameworkBundle\Component\Layout\Loader\Generator\Extension;

use Labudzinski\TestFrameworkBundle\Component\Layout\Extension\Theme\PathProvider\PathProviderInterface;
use Labudzinski\TestFrameworkBundle\Component\Layout\Extension\Theme\Visitor\ImportVisitor;
use Labudzinski\TestFrameworkBundle\Component\Layout\Loader\Generator\ConfigLayoutUpdateGeneratorExtensionInterface;
use Labudzinski\TestFrameworkBundle\Component\Layout\Loader\Generator\GeneratorData;
use Labudzinski\TestFrameworkBundle\Component\Layout\Loader\Visitor\VisitorCollection;

class ImportsLayoutUpdateExtension implements ConfigLayoutUpdateGeneratorExtensionInterface
{
    const NODE_IMPORTS = 'imports';

    /**
     * {@inheritdoc}
     */
    public function prepare(GeneratorData $data, VisitorCollection $visitorCollection)
    {
        $source = $data->getSource();

        // layout update contains imports
        if (!empty($source[self::NODE_IMPORTS])) {
            $visitorCollection->append(new ImportsAwareLayoutUpdateVisitor($source[self::NODE_IMPORTS]));
        }

        // imported layout update
        $delimiter = PathProviderInterface::DELIMITER;
        if (strpos($data->getFilename(), $delimiter.ImportVisitor::IMPORT_FOLDER.$delimiter) !== false) {
            $visitorCollection->append(new ImportLayoutUpdateVisitor());
        }
    }
}
