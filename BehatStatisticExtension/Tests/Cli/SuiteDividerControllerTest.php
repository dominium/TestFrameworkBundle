<?php

namespace Labudzinski\TestFrameworkBundle\BehatStatisticExtension\Tests\Cli;

use Labudzinski\TestFrameworkBundle\BehatStatisticExtension\Cli\SuiteDividerController;
use Labudzinski\TestFrameworkBundle\BehatStatisticExtension\Suite\SuiteConfigurationRegistry;
use Labudzinski\TestFrameworkBundle\BehatStatisticExtension\Tests\Stub\InputStub;
use Labudzinski\TestFrameworkBundle\BehatStatisticExtension\Tests\Stub\OutputStub;
use Symfony\Component\Console\Command\Command;

class SuiteDividerControllerTest extends \PHPUnit_Framework_TestCase
{
    public function testConfigure()
    {
        $suiteConfigRegistry = $this->getMockBuilder(SuiteConfigurationRegistry::class)
            ->disableOriginalConstructor()
            ->getMock();
        $controller = new SuiteDividerController($suiteConfigRegistry);
        $command = new Command('test');

        $controller->configure($command);

        $this->assertTrue($command->getDefinition()->hasOption('suite-divider'));
        $this->assertTrue($command->getDefinition()->getOption('suite-divider')->isValueRequired());
    }

    public function testExecute()
    {
        $suiteConfigRegistry = $this->getMockBuilder(SuiteConfigurationRegistry::class)
            ->disableOriginalConstructor()
            ->getMock();
        $suiteConfigRegistry->expects($this->once())->method('divideSuites')->with(5);

        $controller = new SuiteDividerController($suiteConfigRegistry);
        $controller->execute(new InputStub('', [], ['suite-divider' => 5]), new OutputStub());
    }

    public function testNotExecute()
    {
        $suiteConfigRegistry = $this->getMockBuilder(SuiteConfigurationRegistry::class)
            ->disableOriginalConstructor()
            ->getMock();
        $suiteConfigRegistry->expects($this->never())->method('divideSuites');

        $controller = new SuiteDividerController($suiteConfigRegistry);
        $controller->execute(new InputStub('', [], []), new OutputStub());
    }
}
