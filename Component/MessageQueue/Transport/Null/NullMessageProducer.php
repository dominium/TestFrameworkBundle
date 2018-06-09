<?php
namespace Labudzinski\TestFrameworkBundle\Component\MessageQueue\Transport\Null;

use Labudzinski\TestFrameworkBundle\Component\MessageQueue\Transport\DestinationInterface;
use Labudzinski\TestFrameworkBundle\Component\MessageQueue\Transport\MessageInterface;
use Labudzinski\TestFrameworkBundle\Component\MessageQueue\Transport\MessageProducerInterface;

class NullMessageProducer implements MessageProducerInterface
{
    /**
     * {@inheritdoc}
     */
    public function send(DestinationInterface $destination, MessageInterface $message)
    {
    }
}
