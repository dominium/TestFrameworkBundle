<?php
namespace Labudzinski\TestFrameworkBundle\Component\MessageQueue\Transport\Null;

use Labudzinski\TestFrameworkBundle\Component\MessageQueue\Transport\TopicInterface;

class NullTopic implements TopicInterface
{
    /**
     * @var string
     */
    private $name;

    /**
     * @param string $name
     */
    public function __construct($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getTopicName()
    {
        return $this->name;
    }
}
