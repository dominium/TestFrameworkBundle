<?php
namespace Labudzinski\TestFrameworkBundle\Component\MessageQueue\Client;

use Labudzinski\TestFrameworkBundle\Component\MessageQueue\Transport\MessageInterface;
use Labudzinski\TestFrameworkBundle\Component\MessageQueue\Transport\QueueInterface;

interface DriverInterface
{
    /**
     * @return MessageInterface
     */
    public function createTransportMessage();

    /**
     * @param QueueInterface $queue
     * @param Message $message
     */
    public function send(QueueInterface $queue, Message $message);

    /**
     * @param string $queueName
     *
     * @return QueueInterface
     */
    public function createQueue($queueName);

    /**
     * @return Config
     */
    public function getConfig();
}
