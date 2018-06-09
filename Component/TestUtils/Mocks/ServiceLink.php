<?php

namespace Labudzinski\TestFrameworkBundle\Component\TestUtils\Mocks;

use Labudzinski\TestFrameworkBundle\Component\DependencyInjection\ServiceLink as BaseServiceLink;

class ServiceLink extends BaseServiceLink
{
    /** @var object */
    protected $service;

    /**
     * @param object $service
     */
    public function __construct($service)
    {
        $this->service = $service;
    }

    /**
     * {@inheritdoc}
     */
    public function getService()
    {
        return $this->service;
    }
}
