<?php

namespace Labudzinski\TestFrameworkBundle\Tests\Unit\Behat\Cli;

use Labudzinski\TestFrameworkBundle\Behat\Cli\AvailableReferencesController;
use Labudzinski\TestFrameworkBundle\Behat\Fixtures\OroAliceLoader;
use Labudzinski\TestFrameworkBundle\Behat\Isolation\DoctrineIsolator;
use Labudzinski\TestFrameworkBundle\Tests\Unit\Stub\KernelStub;
use Labudzinski\TestFrameworkBundle\Component\Testing\Unit\Command\Stub\InputStub;
use Labudzinski\TestFrameworkBundle\Component\Testing\Unit\Command\Stub\OutputStub;
use Symfony\Component\Console\Command\Command;

class AvailableReferencesControllerTest extends \PHPUnit_Framework_TestCase
{
    public function testConfigure()
    {
        $aliceLoader = new OroAliceLoader();
        $doctrineIsolator = $this->createMock(DoctrineIsolator::class);
        $kernel = new KernelStub();
        $controller = new AvailableReferencesController($aliceLoader, $doctrineIsolator, $kernel);

        $command = new Command('test');
        $controller->configure($command);

        $this->assertTrue($command->getDefinition()->hasOption('available-references'));
        $this->assertFalse($command->getDefinition()->getOption('available-references')->isValueRequired());
        $this->assertEmpty($command->getDefinition()->getOption('available-references')->getDefault());
    }

    public function testExecute()
    {
        $aliceLoader = new OroAliceLoader();
        $doctrineIsolator = $this->createMock(DoctrineIsolator::class);
        $doctrineIsolator->expects($this->once())->method('initReferences');
        $kernel = new KernelStub();
        $controller = new AvailableReferencesController($aliceLoader, $doctrineIsolator, $kernel);
        $output = new OutputStub();
        $returnCode = $controller->execute(new InputStub('', [], ['available-references' => true]), $output);
        $this->assertSame(0, $returnCode);
    }

    public function testNotExecute()
    {
        $aliceLoader = new OroAliceLoader();
        $doctrineIsolator = $this->createMock(DoctrineIsolator::class);
        $doctrineIsolator->expects($this->never())->method('initReferences');
        $kernel = new KernelStub();
        $controller = new AvailableReferencesController($aliceLoader, $doctrineIsolator, $kernel);
        $output = new OutputStub();
        $returnCode = $controller->execute(new InputStub(), $output);
        $this->assertNotSame(0, $returnCode);
    }
}
