<?php

namespace Labudzinski\TestFrameworkBundle\Component\Layout\Loader\Generator\Extension;

use CG\Generator\PhpMethod;
use CG\Generator\PhpParameter;
use CG\Generator\PhpProperty;
use Labudzinski\TestFrameworkBundle\Component\Layout\Loader\Generator\VisitContext;
use Labudzinski\TestFrameworkBundle\Component\Layout\Loader\Visitor\VisitorInterface;

class ImportLayoutUpdateVisitor implements VisitorInterface
{
    /**
     * {@inheritdoc}
     */
    public function startVisit(VisitContext $visitContext)
    {
        $writer = $visitContext->createWriter();
        $class = $visitContext->getClass();
        $class->addUseStatement('Labudzinski\TestFrameworkBundle\Component\Layout\ImportLayoutManipulator');
        $class->addInterfaceName('Labudzinski\TestFrameworkBundle\Component\Layout\LayoutUpdateImportInterface');
        $class->addInterfaceName('Labudzinski\TestFrameworkBundle\Component\Layout\IsApplicableLayoutUpdateInterface');

        $setFactoryMethod = PhpMethod::create('isApplicable');
        $setFactoryMethod->addParameter(
            PhpParameter::create('context')
                ->setType('\Labudzinski\TestFrameworkBundle\Component\Layout\ContextInterface')
        );
        $setFactoryMethod->setBody($writer->reset()->write('return true;')->getContent());
        $class->setMethod($setFactoryMethod);
        
        $setFactoryMethod = PhpMethod::create('getImport');
        $setFactoryMethod->setBody($writer->reset()->write('return $this->import;')->getContent());
        $class->setMethod($setFactoryMethod);

        $setFactoryMethod = PhpMethod::create('setImport');
        $setFactoryMethod->addParameter(
            PhpParameter::create('import')
                ->setType('Labudzinski\TestFrameworkBundle\Component\Layout\Model\LayoutUpdateImport')
        );
        $setFactoryMethod->setBody($writer->reset()->write('$this->import = $import;')->getContent());
        $class->setMethod($setFactoryMethod);

        $factoryProperty = PhpProperty::create('import');
        $factoryProperty->setVisibility(PhpProperty::VISIBILITY_PRIVATE);
        $class->setProperty($factoryProperty);

        $setFactoryMethod = PhpMethod::create('setParentUpdate');
        $setFactoryMethod->addParameter(
            PhpParameter::create('parentLayoutUpdate')
                ->setType('\Labudzinski\TestFrameworkBundle\Component\Layout\ImportsAwareLayoutUpdateInterface')
        );
        $setFactoryMethod->setBody(
            $writer->reset()->write('$this->parentLayoutUpdate = $parentLayoutUpdate;')
            ->getContent()
        );
        $class->setMethod($setFactoryMethod);

        $factoryProperty = PhpProperty::create('parentLayoutUpdate');
        $factoryProperty->setVisibility(PhpProperty::VISIBILITY_PRIVATE);
        $class->setProperty($factoryProperty);

        $visitContext->getUpdateMethodWriter()
            ->writeln('if (null === $this->import) {')
            ->indent()
            ->writeln(
                'throw new \\RuntimeException(\'Missing import configuration for layout update\');'
            )
            ->outdent()
            ->writeln('}')
            ->writeln('')
            ->writeln('if ($this->parentLayoutUpdate instanceof Labudzinski\TestFrameworkBundle\Component\Layout\IsApplicableLayoutUpdateInterface')
            ->indent()
            ->writeln('&& !$this->parentLayoutUpdate->isApplicable($item->getContext())) {')
            ->writeln('return;')
            ->outdent()
            ->writeln('}')
            ->writeln('')
            ->writeln('$layoutManipulator  = new ImportLayoutManipulator($layoutManipulator, $this->import);');
    }

    /**
     * {@inheritdoc}
     */
    public function endVisit(VisitContext $visitContext)
    {
    }
}
