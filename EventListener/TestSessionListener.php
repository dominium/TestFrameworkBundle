<?php

namespace Labudzinski\TestFrameworkBundle\EventListener;

use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\EventListener\TestSessionListener as BaseTestSessionListener;

class TestSessionListener extends BaseTestSessionListener
{
    public function onKernelRequest(GetResponseEvent $event)
    {
        $session = $this->getSession();
        if (!$session) {
            return;
        }

        if ($session->getId() === $event->getRequest()->cookies->get($session->getName())) {
            return;
        }

        parent::onKernelRequest($event);
    }
}
