<?php
namespace Labudzinski\TestFrameworkBundle\Component\MessageQueue\Consumption\Translator;

use Labudzinski\TestFrameworkBundle\Component\MessageQueue\Consumption\MessageProcessorInterface;
use Labudzinski\TestFrameworkBundle\Component\MessageQueue\Transport\MessageInterface;
use Labudzinski\TestFrameworkBundle\Component\MessageQueue\Transport\MessageProducerInterface;
use Labudzinski\TestFrameworkBundle\Component\MessageQueue\Transport\SessionInterface;

class MessageTranslatorProcessor implements MessageProcessorInterface
{
    /**
     * @var string
     */
    protected $topicName;

    /**
     * @param string $topicName
     */
    public function __construct($topicName)
    {
        $this->topicName = $topicName;
    }

    /**
     * {@inheritdoc}
     */
    public function process(MessageInterface $message, SessionInterface $session)
    {
        $topic = $session->createTopic($this->topicName);
        $newMessage = $session->createMessage($message->getBody(), $message->getProperties(), $message->getHeaders());

        $session->createProducer()->send($topic, $newMessage);

        return self::ACK;
    }
}
