<?php

namespace Labudzinski\TestFrameworkBundle\Component\DependencyInjection\Tests\Unit\Stub;

use Labudzinski\TestFrameworkBundle\Component\DependencyInjection\ServiceLinkRegistry;
use Labudzinski\TestFrameworkBundle\Component\DependencyInjection\ServiceLinkRegistryAwareInterface;

class ServiceLinkRegistryAwareStub implements ServiceLinkRegistryAwareInterface
{
    public function setServiceLinkRegistry(ServiceLinkRegistry $serviceLinkAliasRegistry)
    {
        // a stub
    }
}
