<?php

namespace Labudzinski\TestFrameworkBundle\Component\ChainProcessor\Debug;

use Labudzinski\TestFrameworkBundle\Component\ChainProcessor\ApplicableCheckerInterface;
use Labudzinski\TestFrameworkBundle\Component\ChainProcessor\ChainApplicableChecker;
use Labudzinski\TestFrameworkBundle\Component\ChainProcessor\ContextInterface;

class TraceableChainApplicableChecker extends ChainApplicableChecker
{
    /** @var TraceLogger */
    protected $logger;

    /**
     * @param TraceLogger $logger
     */
    public function __construct(TraceLogger $logger)
    {
        $this->logger = $logger;
    }

    /**
     * {@inheritdoc}
     */
    protected function executeChecker(
        ApplicableCheckerInterface $checker,
        ContextInterface $context,
        array $processorAttributes
    ) {
        $this->logger->startApplicableChecker(get_class($checker));
        $result = $checker->isApplicable($context, $processorAttributes);
        $this->logger->stopApplicableChecker();

        return $result;
    }
}
