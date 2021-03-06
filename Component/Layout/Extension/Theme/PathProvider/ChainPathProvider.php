<?php

namespace Labudzinski\TestFrameworkBundle\Component\Layout\Extension\Theme\PathProvider;

use Labudzinski\TestFrameworkBundle\Component\Layout\ContextAwareInterface;
use Labudzinski\TestFrameworkBundle\Component\Layout\ContextInterface;

class ChainPathProvider implements ContextAwareInterface, PathProviderInterface
{
    /** @var array */
    protected $providers = [];

    /** @var array */
    protected $sorted;

    /**
     * For automatically injecting provider should be registered as DI service
     * with tag layout.resource.path_provider
     *
     * @param PathProviderInterface $provider
     * @param int                   $priority
     */
    public function addProvider(PathProviderInterface $provider, $priority = 0)
    {
        $this->providers[$priority][] = $provider;
        $this->sorted                 = null;
    }

    /**
     * {@inheritdoc}
     */
    public function setContext(ContextInterface $context)
    {
        $providers = $this->getProviders();
        foreach ($providers as $provider) {
            if ($provider instanceof ContextAwareInterface) {
                $provider->setContext($context);
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getPaths(array $existingPaths)
    {
        $providers = $this->getProviders();
        foreach ($providers as $provider) {
            $existingPaths = $provider->getPaths($existingPaths);
        }

        return array_unique($existingPaths, SORT_STRING);
    }

    /**
     * @return PathProviderInterface[]
     */
    protected function getProviders()
    {
        if (!$this->sorted) {
            krsort($this->providers);
            $this->sorted = !empty($this->providers)
                ? call_user_func_array('array_merge', $this->providers)
                : [];
        }

        return $this->sorted;
    }
}
