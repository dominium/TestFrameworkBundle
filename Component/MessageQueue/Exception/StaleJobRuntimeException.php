<?php

namespace Labudzinski\TestFrameworkBundle\Component\MessageQueue\Exception;

use Labudzinski\TestFrameworkBundle\Component\MessageQueue\Consumption\Exception\RejectMessageExceptionInterface;

class StaleJobRuntimeException extends \RuntimeException implements RejectMessageExceptionInterface
{
    /**
     * @return StaleJobRuntimeException
     */
    public static function create()
    {
        return new static('Stale Jobs cannot be run');
    }
}
