<?php

namespace Labudzinski\TestFrameworkBundle\Component\Routing\Loader;

use Labudzinski\TestFrameworkBundle\Component\Routing\Resolver\RouteCollectionAccessor;
use Labudzinski\TestFrameworkBundle\Component\Routing\Resolver\RouteOptionsResolverInterface;
use Labudzinski\TestFrameworkBundle\Component\Routing\Resolver\SortableRouteCollection;
use Symfony\Component\Config\Loader\Loader;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

abstract class AbstractLoader extends Loader
{
    /** @var RouteOptionsResolverInterface */
    protected $routeOptionsResolver;

    /**
     * @param RouteOptionsResolverInterface $routeOptionsResolver
     */
    public function __construct(RouteOptionsResolverInterface $routeOptionsResolver)
    {
        $this->routeOptionsResolver = $routeOptionsResolver;
    }

    /**
     * @param mixed       $resource
     * @param string|null $type
     *
     * @return RouteCollection
     */
    public function load($resource, $type = null)
    {
        $routes = new SortableRouteCollection();
        $this->loadRoutes($routes);

        $routeCollectionAccessor = new RouteCollectionAccessor($routes);
        /** @var Route $route */
        foreach ($routes as $route) {
            $this->routeOptionsResolver->resolve($route, $routeCollectionAccessor);
        }

        $routes->sortByPriority();

        return $routes;
    }

    /**
     * @param RouteCollection $routes
     */
    protected function loadRoutes(RouteCollection $routes)
    {
        $resources = $this->getResources();
        foreach ($resources as $resource) {
            $routes->addCollection($this->resolve($resource)->load($resource));
        }
    }

    /**
     * Returns the list of resources to be loaded by this loader
     *
     * @return array
     */
    abstract protected function getResources();
}
