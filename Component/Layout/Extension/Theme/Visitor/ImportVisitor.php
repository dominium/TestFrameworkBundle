<?php

namespace Labudzinski\TestFrameworkBundle\Component\Layout\Extension\Theme\Visitor;

use Labudzinski\TestFrameworkBundle\Component\Layout\ContextInterface;
use Labudzinski\TestFrameworkBundle\Component\Layout\Exception\LogicException;
use Labudzinski\TestFrameworkBundle\Component\Layout\Extension\Theme\Model\DependencyInitializer;
use Labudzinski\TestFrameworkBundle\Component\Layout\Extension\Theme\Model\ThemeManager;
use Labudzinski\TestFrameworkBundle\Component\Layout\Extension\Theme\ResourceProvider\ResourceProviderInterface;
use Labudzinski\TestFrameworkBundle\Component\Layout\Extension\Theme\ThemeExtension;
use Labudzinski\TestFrameworkBundle\Component\Layout\ImportsAwareLayoutUpdateInterface;
use Labudzinski\TestFrameworkBundle\Component\Layout\IsApplicableLayoutUpdateInterface;
use Labudzinski\TestFrameworkBundle\Component\Layout\LayoutUpdateImportInterface;
use Labudzinski\TestFrameworkBundle\Component\Layout\Loader\Generator\ElementDependentLayoutUpdateInterface;
use Labudzinski\TestFrameworkBundle\Component\Layout\Loader\LayoutUpdateLoaderInterface;
use Labudzinski\TestFrameworkBundle\Component\Layout\Model\LayoutUpdateImport;

class ImportVisitor implements VisitorInterface
{
    const IMPORT_FOLDER = 'imports';

    /** @var LayoutUpdateLoaderInterface */
    private $loader;

    /** @var DependencyInitializer */
    private $dependencyInitializer;

    /** @var ResourceProviderInterface */
    private $resourceProvider;

    /** @var ThemeManager */
    private $themeManager;

    /** @var array */
    private $updates = [];

    /**
     * @param LayoutUpdateLoaderInterface $loader
     * @param DependencyInitializer $dependencyInitializer
     * @param ResourceProviderInterface $resourceProvider
     * @param ThemeManager $themeManager
     */
    public function __construct(
        LayoutUpdateLoaderInterface $loader,
        DependencyInitializer $dependencyInitializer,
        ResourceProviderInterface $resourceProvider,
        ThemeManager $themeManager
    ) {
        $this->loader = $loader;
        $this->dependencyInitializer = $dependencyInitializer;
        $this->resourceProvider = $resourceProvider;
        $this->themeManager = $themeManager;
    }

    /**
     * {@inheritdoc}
     */
    public function walkUpdates(array &$updates, ContextInterface $context)
    {
        $this->updates = &$updates;

        foreach ($updates as $group) {
            foreach ($group as $update) {
                if ($update instanceof ImportsAwareLayoutUpdateInterface) {
                    $this->loadImportUpdate($update, $context);
                }
            }
        }
    }

    /**
     * @param ImportsAwareLayoutUpdateInterface $parentUpdate
     * @param ContextInterface $context
     *
     * @throws LogicException
     */
    private function loadImportUpdate($parentUpdate, ContextInterface $context)
    {
        if ($parentUpdate instanceof IsApplicableLayoutUpdateInterface && !$parentUpdate->isApplicable($context)) {
            return;
        }

        $imports = $parentUpdate->getImports();
        if (!is_array($imports)) {
            throw new LogicException(
                sprintf('Imports statement should be an array, %s given', gettype($imports))
            );
        }

        $importsReversed = array_reverse($imports);
        foreach ($importsReversed as $importData) {
            $import = $this->createImport($importData);
            if ($parentUpdate instanceof LayoutUpdateImportInterface) {
                $import->setParent($parentUpdate->getImport());
            }

            $files = $this->getImportResources($context->get(ThemeExtension::THEME_KEY), $import->getId());
            foreach ($files as $file) {
                $update = $this->loader->load($file);
                if ($update instanceof LayoutUpdateImportInterface) {
                    $update->setImport($import);
                    $update->setParentUpdate($parentUpdate);
                }

                $this->insertUpdate($parentUpdate, $update);

                $this->dependencyInitializer->initialize($update);

                if ($update instanceof ImportsAwareLayoutUpdateInterface) {
                    $this->loadImportUpdate($update, $context);
                }
            }
        }
    }

    /**
     * Insert import update right after its parent update
     *
     * @param ImportsAwareLayoutUpdateInterface $parentUpdate
     * @param LayoutUpdateImportInterface $update
     */
    private function insertUpdate($parentUpdate, $update)
    {
        $el = $update instanceof ElementDependentLayoutUpdateInterface
            ? $update->getElement()
            : 'root';

        $parentUpdateIndex = array_search($parentUpdate, $this->updates[$el]);

        $this->updates[$el] = array_merge(
            array_slice($this->updates[$el], 0, $parentUpdateIndex, true),
            [$update],
            array_slice($this->updates[$el], $parentUpdateIndex, null, true)
        );
    }

    /**
     * @param string|array $importProperties
     *
     * @return LayoutUpdateImport
     */
    private function createImport($importProperties)
    {
        if (!is_array($importProperties)) {
            $importProperties = [ImportsAwareLayoutUpdateInterface::ID_KEY => $importProperties];
        }

        return LayoutUpdateImport::createFromArray($importProperties);
    }

    /**
     * @param string $themeName
     * @param string $importId
     *
     * @return array
     */
    private function getImportResources($themeName, $importId)
    {
        $theme = $this->themeManager->getTheme($themeName);

        $path = implode(
            DIRECTORY_SEPARATOR,
            [$theme->getName(), self::IMPORT_FOLDER, $importId]
        );

        $files = $this->resourceProvider->findApplicableResources([$path]);
        if ($theme->getParentTheme()) {
            $files = array_merge($this->getImportResources($theme->getParentTheme(), $importId), $files);
        }

        return $files;
    }
}
