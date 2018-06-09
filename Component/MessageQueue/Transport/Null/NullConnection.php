<?php
namespace Labudzinski\TestFrameworkBundle\Component\MessageQueue\Transport\Null;

use Labudzinski\TestFrameworkBundle\Component\MessageQueue\Transport\ConnectionInterface;

class NullConnection implements ConnectionInterface
{
    /**
     * {@inheritdoc}
     *
     * @return NullSession
     */
    public function createSession()
    {
        return new NullSession();
    }

    /**
     * {@inheritdoc}
     */
    public function close()
    {
    }
}
