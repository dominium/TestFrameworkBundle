<?php
namespace Labudzinski\TestFrameworkBundle\Component\MessageQueue\Transport;

interface MessageProducerInterface
{
    /**
     * @param DestinationInterface $destination
     * @param MessageInterface $message
     *
     * @return void
     *
     * @throws \Labudzinski\TestFrameworkBundle\Component\MessageQueue\Transport\Exception\Exception - if the JMS provider fails to send
     * the message due to some internal error.
     *
     * @throws \Labudzinski\TestFrameworkBundle\Component\MessageQueue\Transport\Exception\InvalidDestinationException - if a client uses
     * this method with an invalid destination.
     *
     * @throws \Labudzinski\TestFrameworkBundle\Component\MessageQueue\Transport\Exception\InvalidMessageException - if an invalid message
     * is specified.
     */
    public function send(DestinationInterface $destination, MessageInterface $message);
}
