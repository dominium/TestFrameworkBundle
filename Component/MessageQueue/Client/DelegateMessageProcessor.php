<?php
namespace Labudzinski\TestFrameworkBundle\Component\MessageQueue\Client;

use Labudzinski\TestFrameworkBundle\Component\MessageQueue\Consumption\MessageProcessorInterface;
use Labudzinski\TestFrameworkBundle\Component\MessageQueue\Transport\MessageInterface;
use Labudzinski\TestFrameworkBundle\Component\MessageQueue\Transport\SessionInterface as TransportSession;

class DelegateMessageProcessor implements MessageProcessorInterface
{
    /**
     * @var MessageProcessorRegistryInterface
     */
    protected $registry;

    /**
     * @param MessageProcessorRegistryInterface $registry
     */
    public function __construct(MessageProcessorRegistryInterface $registry)
    {
        $this->registry = $registry;
    }

    /**
     * {@inheritdoc}
     */
    public function process(MessageInterface $message, TransportSession $session)
    {
        $processorName = $message->getProperty(Config::PARAMETER_PROCESSOR_NAME);
        if (false == $processorName) {
            throw new \LogicException(sprintf(
                'Got message without required parameter: "%s"',
                Config::PARAMETER_PROCESSOR_NAME
            ));
        }

        return $this->registry->get($processorName)->process($message, $session);
    }
}
