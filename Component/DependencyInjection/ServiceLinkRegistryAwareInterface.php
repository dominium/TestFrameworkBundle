<?php

namespace Labudzinski\TestFrameworkBundle\Component\DependencyInjection;

interface ServiceLinkRegistryAwareInterface
{
    /**
     * @param ServiceLinkRegistry $serviceLinkAliasRegistry
     */
    public function setServiceLinkRegistry(ServiceLinkRegistry $serviceLinkAliasRegistry);
}
