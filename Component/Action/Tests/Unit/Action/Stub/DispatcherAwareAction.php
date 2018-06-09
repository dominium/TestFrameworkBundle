<?php

namespace Labudzinski\TestFrameworkBundle\Component\Action\Tests\Unit\Action\Stub;

use Labudzinski\TestFrameworkBundle\Component\Action\Action\EventDispatcherAwareActionInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class DispatcherAwareAction implements EventDispatcherAwareActionInterface
{
    /**
     * {@inheritdoc}
     */
    public function setDispatcher(EventDispatcherInterface $eventDispatcher)
    {
    }
}
