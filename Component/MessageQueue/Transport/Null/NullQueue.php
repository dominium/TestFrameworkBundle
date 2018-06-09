<?php
namespace Labudzinski\TestFrameworkBundle\Component\MessageQueue\Transport\Null;

use Labudzinski\TestFrameworkBundle\Component\MessageQueue\Transport\QueueInterface;

class NullQueue implements QueueInterface
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
    public function getQueueName()
    {
        return $this->name;
    }
}
