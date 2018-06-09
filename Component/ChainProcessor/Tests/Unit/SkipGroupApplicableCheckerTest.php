<?php

namespace Labudzinski\TestFrameworkBundle\Component\ChainProcessor\Tests\Unit;

use Labudzinski\TestFrameworkBundle\Component\ChainProcessor\ChainApplicableChecker;
use Labudzinski\TestFrameworkBundle\Component\ChainProcessor\Context;
use Labudzinski\TestFrameworkBundle\Component\ChainProcessor\ContextInterface;
use Labudzinski\TestFrameworkBundle\Component\ChainProcessor\ProcessorFactoryInterface;
use Labudzinski\TestFrameworkBundle\Component\ChainProcessor\ProcessorIterator;
use Labudzinski\TestFrameworkBundle\Component\ChainProcessor\SkipGroupApplicableChecker;

class SkipGroupApplicableCheckerTest extends \PHPUnit_Framework_TestCase
{
    public function testSkipGroupApplicableChecker()
    {
        $context = new Context();
        $processors = [
            ['processor1', ['group' => 'group1']],
            ['processor2', ['group' => 'group2']],
            ['processor3', ['group' => 'group2']],
            ['processor4', ['group' => 'group3']]
        ];

        $iterator = new ProcessorIterator(
            $processors,
            $context,
            $this->getApplicableChecker(),
            $this->getProcessorFactory(
                [
                    'processor1' => function (ContextInterface $context) {
                        $context->skipGroup('group2');
                    }
                ]
            )
        );

        $this->assertProcessors(
            [
                'processor1',
                'processor4',
            ],
            $iterator,
            $context
        );
    }

    /**
     * @return ChainApplicableChecker
     */
    protected function getApplicableChecker()
    {
        $checker = new ChainApplicableChecker();
        $checker->addChecker(new SkipGroupApplicableChecker());

        return $checker;
    }

    /**
     * @param callable[] $callbacks
     *
     * @return ProcessorFactoryInterface
     */
    protected function getProcessorFactory(array $callbacks = [])
    {
        $factory = $this->createMock('Labudzinski\TestFrameworkBundle\Component\ChainProcessor\ProcessorFactoryInterface');
        $factory->expects($this->any())
            ->method('getProcessor')
            ->willReturnCallback(
                function ($processorId) use ($callbacks) {
                    return new ProcessorMock(
                        $processorId,
                        isset($callbacks[$processorId]) ? $callbacks[$processorId] : null
                    );
                }
            );

        return $factory;
    }

    /**
     * @param string[]         $expectedProcessorIds
     * @param \Iterator        $processors
     * @param ContextInterface $context
     */
    protected function assertProcessors(array $expectedProcessorIds, \Iterator $processors, ContextInterface $context)
    {
        $processorIds = [];
        /** @var ProcessorMock $processor */
        foreach ($processors as $processor) {
            $processor->process($context);
            $processorIds[] = $processor->getProcessorId();
        }

        $this->assertEquals($expectedProcessorIds, $processorIds);
    }
}
