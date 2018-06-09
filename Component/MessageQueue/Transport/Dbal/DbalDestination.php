<?php
namespace Labudzinski\TestFrameworkBundle\Component\MessageQueue\Transport\Dbal;

use Labudzinski\TestFrameworkBundle\Component\MessageQueue\Transport\QueueInterface;
use Labudzinski\TestFrameworkBundle\Component\MessageQueue\Transport\TopicInterface;

class DbalDestination implements TopicInterface, QueueInterface
{
    /**
     * @var string
     */
    private $destinationName;

    /**
     * @param string $name
     */
    public function __construct($name)
    {
        $this->destinationName = $name;
    }

    /**
     * {@inheritdoc}
     */
    public function getQueueName()
    {
        return $this->destinationName;
    }

    /**
     * {@inheritdoc}
     */
    public function getTopicName()
    {
        return $this->destinationName;
    }
}
