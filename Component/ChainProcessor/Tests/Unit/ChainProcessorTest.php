<?php

namespace Labudzinski\TestFrameworkBundle\Component\ChainProcessor\Tests\Unit;

use Labudzinski\TestFrameworkBundle\Component\ChainProcessor\ChainProcessor;
use Labudzinski\TestFrameworkBundle\Component\ChainProcessor\Context;
use Labudzinski\TestFrameworkBundle\Component\ChainProcessor\Exception\ExecutionFailedException;
use Labudzinski\TestFrameworkBundle\Component\ChainProcessor\ProcessorBag;
use Labudzinski\TestFrameworkBundle\Component\ChainProcessor\ProcessorBagConfigBuilder;
use Labudzinski\TestFrameworkBundle\Component\ChainProcessor\ProcessorFactoryInterface;
use Labudzinski\TestFrameworkBundle\Component\ChainProcessor\ProcessorInterface;

class ChainProcessorTest extends \PHPUnit_Framework_TestCase
{
    public function testExecuteProcessors()
    {
        $processor1 = $this->createMock(ProcessorInterface::class);
        $processor2 = $this->createMock(ProcessorInterface::class);

        $factory = $this->createMock(ProcessorFactoryInterface::class);
        $factory->expects(self::exactly(2))
            ->method('getProcessor')
            ->willReturnOnConsecutiveCalls($processor1, $processor2);

        $builder = new ProcessorBagConfigBuilder();
        $processorBag = new ProcessorBag($builder, $factory);
        $builder->addProcessor('processor1', [], 'action1', null, 20);
        $builder->addProcessor('processor2', [], 'action1', null, 10);

        $context = new Context();
        $context->setAction('action1');

        $processor1->expects(self::once())
            ->method('process')
            ->with(self::identicalTo($context));
        $processor2->expects(self::once())
            ->method('process')
            ->with(self::identicalTo($context));

        $chainProcessor = new ChainProcessor($processorBag);
        $chainProcessor->process($context);
    }

    public function testExecuteProcessorsFailure()
    {
        $processor1 = $this->createMock(ProcessorInterface::class);
        $processor2 = $this->createMock(ProcessorInterface::class);

        $factory = $this->createMock(ProcessorFactoryInterface::class);
        $factory->expects(self::exactly(2))
            ->method('getProcessor')
            ->willReturnOnConsecutiveCalls($processor1, $processor2);

        $builder = new ProcessorBagConfigBuilder();
        $processorBag = new ProcessorBag($builder, $factory);
        $builder->addGroup('group1', 'action1', 20);
        $builder->addGroup('group2', 'action1', 10);
        $builder->addProcessor('processor1', [], 'action1', 'group1', 20);
        $builder->addProcessor('processor2', [], 'action1', 'group2', 20);
        $builder->addProcessor('processor3', [], 'action1', 'group2', 10);

        $context = new Context();
        $context->setAction('action1');

        $processor1->expects(self::once())
            ->method('process')
            ->with(self::identicalTo($context));
        $processor2->expects(self::once())
            ->method('process')
            ->with(self::identicalTo($context))
            ->willThrowException(new \Exception('Some error.'));

        $chainProcessor = new ChainProcessor($processorBag);

        try {
            $chainProcessor->process($context);
            self::fail('An exception expected');
        } catch (ExecutionFailedException $e) {
            self::assertEquals('Processor failed: "processor2". Reason: Some error.', $e->getMessage());
            self::assertEquals('processor2', $e->getProcessorId());
            self::assertEquals('action1', $e->getAction());
            self::assertEquals('group2', $e->getGroup());
            self::assertNotNull($e->getPrevious());
            self::assertEquals('Some error.', $e->getPrevious()->getMessage());
        } catch (\Exception $e) {
            self::fail(sprintf('ExecutionFailedException expected. Got: %s', get_class($e)));
        }
    }
}
