<?php
namespace Labudzinski\TestFrameworkBundle\Component\MessageQueue\Transport\Null;

use Labudzinski\TestFrameworkBundle\Component\MessageQueue\Transport\DestinationInterface;
use Labudzinski\TestFrameworkBundle\Component\MessageQueue\Transport\MessageConsumerInterface;
use Labudzinski\TestFrameworkBundle\Component\MessageQueue\Transport\MessageInterface;

class NullMessageConsumer implements MessageConsumerInterface
{
    /**
     * @var DestinationInterface
     */
    private $queue;

    /**
     * @param DestinationInterface $queue
     */
    public function __construct(DestinationInterface $queue)
    {
        $this->queue = $queue;
    }

    /**
     * {@inheritdoc}
     */
    public function getQueue()
    {
        return $this->queue;
    }

    /**
     * {@inheritdoc}
     *
     * @return null
     */
    public function receive($timeout = 0)
    {
        return null;
    }

    /**
     * {@inheritdoc}
     *
     * @return null
     */
    public function receiveNoWait()
    {
        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function acknowledge(MessageInterface $message)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function reject(MessageInterface $message, $requeue = false)
    {
    }
}
