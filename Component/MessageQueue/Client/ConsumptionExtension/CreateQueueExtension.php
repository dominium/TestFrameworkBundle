<?php

namespace Labudzinski\TestFrameworkBundle\Component\MessageQueue\Client\ConsumptionExtension;

use Labudzinski\TestFrameworkBundle\Component\MessageQueue\Client\DriverInterface;
use Labudzinski\TestFrameworkBundle\Component\MessageQueue\Consumption\AbstractExtension;
use Labudzinski\TestFrameworkBundle\Component\MessageQueue\Consumption\Context;
use Labudzinski\TestFrameworkBundle\Component\MessageQueue\Transport\QueueCollection;

class CreateQueueExtension extends AbstractExtension
{
    /** @var DriverInterface */
    private $driver;

    /** @var QueueCollection */
    private $createdQueues;

    /**
     * @param DriverInterface      $driver
     * @param QueueCollection|null $createdQueues
     */
    public function __construct(DriverInterface $driver, QueueCollection $createdQueues = null)
    {
        $this->driver = $driver;
        if (null === $createdQueues) {
            $createdQueues = new QueueCollection();
        }
        $this->createdQueues = $createdQueues;
    }

    /**
     * @param Context $context
     */
    public function onBeforeReceive(Context $context)
    {
        $queueName = $context->getQueueName();
        if ($this->createdQueues->has($queueName)) {
            return;
        }

        $this->createdQueues->set($queueName, $this->driver->createQueue($queueName));

        $context->getLogger()->debug(sprintf(
            'Make sure the queue "%s" exists on a broker side.',
            $queueName
        ));
    }
}
