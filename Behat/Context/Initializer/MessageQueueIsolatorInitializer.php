<?php

namespace Labudzinski\TestFrameworkBundle\Behat\Context\Initializer;

use Behat\Behat\Context\Context;
use Behat\Behat\Context\Initializer\ContextInitializer;
use Labudzinski\TestFrameworkBundle\Behat\Isolation\MessageQueueIsolatorAwareInterface;
use Labudzinski\TestFrameworkBundle\Behat\Isolation\MessageQueueIsolatorInterface;

class MessageQueueIsolatorInitializer implements ContextInitializer, MessageQueueIsolatorAwareInterface
{
    /**
     * @var MessageQueueIsolatorInterface
     */
    protected $messageQueueIsolator;

    /**
     * {@inheritdoc}
     */
    public function initializeContext(Context $context)
    {
        if ($context instanceof MessageQueueIsolatorAwareInterface) {
            $context->setMessageQueueIsolator($this->messageQueueIsolator);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function setMessageQueueIsolator(MessageQueueIsolatorInterface $messageQueueIsolator)
    {
        $this->messageQueueIsolator = $messageQueueIsolator;
    }
}
