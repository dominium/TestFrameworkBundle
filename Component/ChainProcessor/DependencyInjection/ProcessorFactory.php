<?php

namespace Labudzinski\TestFrameworkBundle\Component\ChainProcessor\DependencyInjection;

use Labudzinski\TestFrameworkBundle\Component\ChainProcessor\ProcessorFactoryInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * A factory that can be used to get processors from DIC.
 */
class ProcessorFactory implements ProcessorFactoryInterface
{
    /** @var ContainerInterface */
    protected $container;

    /**
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * {@inheritdoc}
     */
    public function getProcessor($processorId)
    {
        return $this->container->get($processorId, ContainerInterface::NULL_ON_INVALID_REFERENCE);
    }
}
