<?php

namespace Labudzinski\TestFrameworkBundle\Component\Layout\Extension\Theme;

use Labudzinski\TestFrameworkBundle\Component\Layout\ContextAwareInterface;
use Labudzinski\TestFrameworkBundle\Component\Layout\ContextInterface;
use Labudzinski\TestFrameworkBundle\Component\Layout\Extension\AbstractExtension;
use Labudzinski\TestFrameworkBundle\Component\Layout\Extension\Theme\Model\DependencyInitializer;
use Labudzinski\TestFrameworkBundle\Component\Layout\Extension\Theme\PathProvider\PathProviderInterface;
use Labudzinski\TestFrameworkBundle\Component\Layout\Extension\Theme\ResourceProvider\ResourceProviderInterface;
use Labudzinski\TestFrameworkBundle\Component\Layout\Extension\Theme\Visitor\VisitorInterface;
use Labudzinski\TestFrameworkBundle\Component\Layout\Loader\Generator\ElementDependentLayoutUpdateInterface;
use Labudzinski\TestFrameworkBundle\Component\Layout\Loader\LayoutUpdateLoaderInterface;

class ThemeExtension extends AbstractExtension
{
    const THEME_KEY = 'theme';

    /** @var LayoutUpdateLoaderInterface */
    protected $loader;

    /** @var DependencyInitializer */
    protected $dependencyInitializer;

    /** @var PathProviderInterface */
    protected $pathProvider;

    /** @var ResourceProviderInterface */
    protected $resourceProvider;

    /** @var VisitorInterface[] */
    protected $visitors = [];

    /** @var array */
    protected $updates = [];

    /**
     * @param LayoutUpdateLoaderInterface $loader
     * @param DependencyInitializer $dependencyInitializer
     * @param PathProviderInterface $pathProvider
     * @param ResourceProviderInterface $resourceProvider
     */
    public function __construct(
        LayoutUpdateLoaderInterface $loader,
        DependencyInitializer $dependencyInitializer,
        PathProviderInterface $pathProvider,
        ResourceProviderInterface $resourceProvider
    ) {
        $this->loader = $loader;
        $this->dependencyInitializer = $dependencyInitializer;
        $this->pathProvider = $pathProvider;
        $this->resourceProvider = $resourceProvider;
    }

    /**
     * @param VisitorInterface $visitor
     */
    public function addVisitor(VisitorInterface $visitor)
    {
        $this->visitors[] = $visitor;
    }

    /**
     * {@inheritdoc}
     */
    protected function loadLayoutUpdates(ContextInterface $context)
    {
        if ($context->getOr(self::THEME_KEY)) {
            $paths = $this->getPaths($context);
            $files = $this->resourceProvider->findApplicableResources($paths);
            foreach ($files as $file) {
                $this->loadLayoutUpdate($file);
            }
        }

        foreach ($this->visitors as $visitor) {
            $visitor->walkUpdates($this->updates, $context);
        }

        return $this->updates;
    }

    /**
     * @param string $file
     *
     * @return array
     */
    protected function loadLayoutUpdate($file)
    {
        $update = $this->loader->load($file);
        if ($update) {
            $el = $update instanceof ElementDependentLayoutUpdateInterface
                ? $update->getElement()
                : 'root';
            $this->updates[$el][] = $update;

            $this->dependencyInitializer->initialize($update);
        }
    }

    /**
     * Return paths that comes from provider and returns array of resource files
     *
     * @param ContextInterface $context
     *
     * @return array
     */
    protected function getPaths(ContextInterface $context)
    {
        if ($this->pathProvider instanceof ContextAwareInterface) {
            $this->pathProvider->setContext($context);
        }

        return $this->pathProvider->getPaths([]);
    }
}
