<?php

namespace Labudzinski\TestFrameworkBundle\Component\MessageQueue\Consumption\Extension;

use Labudzinski\TestFrameworkBundle\Component\MessageQueue\Consumption\AbstractExtension;
use Labudzinski\TestFrameworkBundle\Component\MessageQueue\Consumption\Context;
use Psr\Log\LoggerInterface;

class LoggerExtension extends AbstractExtension
{
    /** @var LoggerInterface */
    private $logger;

    /**
     * @param LoggerInterface $logger
     */
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * {@inheritdoc}
     */
    public function onStart(Context $context)
    {
        $context->setLogger($this->logger);
        $this->logger->debug('Set logger to the context');
    }
}
