<?php
namespace Labudzinski\TestFrameworkBundle\Component\MessageQueue\Client;

use Labudzinski\TestFrameworkBundle\Component\MessageQueue\Consumption\MessageProcessorInterface;

interface MessageProcessorRegistryInterface
{
    /**
     * @param string $processorName
     *
     * @return MessageProcessorInterface
     */
    public function get($processorName);
}
