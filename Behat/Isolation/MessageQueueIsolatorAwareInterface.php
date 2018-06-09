<?php

namespace Labudzinski\TestFrameworkBundle\Behat\Isolation;

interface MessageQueueIsolatorAwareInterface
{
    /**
     * @param MessageQueueIsolatorInterface $messageQueueIsolator
     */
    public function setMessageQueueIsolator(MessageQueueIsolatorInterface $messageQueueIsolator);
}
