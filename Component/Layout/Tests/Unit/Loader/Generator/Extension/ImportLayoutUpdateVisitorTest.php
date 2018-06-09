<?php

namespace Labudzinski\TestFrameworkBundle\Component\Layout\Tests\Unit\Loader\Generator\Extension;

use CG\Core\DefaultGeneratorStrategy;
use CG\Generator\PhpClass;
use CG\Generator\PhpMethod;
use Labudzinski\TestFrameworkBundle\Component\Layout\Loader\Generator\Extension\ImportLayoutUpdateVisitor;
use Labudzinski\TestFrameworkBundle\Component\Layout\Loader\Generator\VisitContext;

class ImportLayoutUpdateVisitorTest extends \PHPUnit_Framework_TestCase
{
    // @codingStandardsIgnoreStart
    public function testVisit()
    {
        $condition = new ImportLayoutUpdateVisitor();
        $phpClass = PhpClass::create('ImportedLayoutUpdate');
        $visitContext = new VisitContext($phpClass);

        $method = PhpMethod::create('testMethod');

        $condition->startVisit($visitContext);
        $visitContext->getUpdateMethodWriter()->writeln('echo 123;');
        $condition->endVisit($visitContext);

        $method->setBody($visitContext->getUpdateMethodWriter()->getContent());
        $phpClass->setMethod($method);
        $strategy = new DefaultGeneratorStrategy();
        $this->assertSame(
<<<CLASS
use Labudzinski\TestFrameworkBundle\Component\Layout\ImportLayoutManipulator;

class ImportedLayoutUpdate implements \Labudzinski\TestFrameworkBundle\Component\Layout\LayoutUpdateImportInterface, \Labudzinski\TestFrameworkBundle\Component\Layout\IsApplicableLayoutUpdateInterface
{
    private \$parentLayoutUpdate;
    private \$import;

    public function testMethod()
    {
        if (null === \$this->import) {
            throw new \RuntimeException('Missing import configuration for layout update');
        }

        if (\$this->parentLayoutUpdate instanceof Labudzinski\TestFrameworkBundle\Component\Layout\IsApplicableLayoutUpdateInterface
            && !\$this->parentLayoutUpdate->isApplicable(\$item->getContext())) {
            return;
        }

        \$layoutManipulator  = new ImportLayoutManipulator(\$layoutManipulator, \$this->import);
        echo 123;
    }

    public function setParentUpdate(\Labudzinski\TestFrameworkBundle\Component\Layout\ImportsAwareLayoutUpdateInterface \$parentLayoutUpdate)
    {
        \$this->parentLayoutUpdate = \$parentLayoutUpdate;
    }

    public function setImport(\Labudzinski\TestFrameworkBundle\Component\Layout\Model\LayoutUpdateImport \$import)
    {
        \$this->import = \$import;
    }

    public function isApplicable(\Labudzinski\TestFrameworkBundle\Component\Layout\ContextInterface \$context)
    {
        return true;
    }

    public function getImport()
    {
        return \$this->import;
    }
}
CLASS
        ,
        $strategy->generate($visitContext->getClass())
        );
    }
    //codingStandardsIgnoreEnd
}
