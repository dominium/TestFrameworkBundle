<?php

namespace Labudzinski\TestFrameworkBundle\Component\Layout\Extension\Theme\PathProvider;

use Labudzinski\TestFrameworkBundle\Component\Layout\ContextAwareInterface;
use Labudzinski\TestFrameworkBundle\Component\Layout\ContextInterface;
use Labudzinski\TestFrameworkBundle\Component\Layout\Extension\Theme\Model\Theme;
use Labudzinski\TestFrameworkBundle\Component\Layout\Extension\Theme\Model\ThemeManager;

class ThemePathProvider implements PathProviderInterface, ContextAwareInterface
{
    /** @var ThemeManager */
    protected $themeManager;

    /** @var ContextInterface */
    protected $context;

    /**
     * @param ThemeManager $themeManager
     */
    public function __construct(ThemeManager $themeManager)
    {
        $this->themeManager = $themeManager;
    }

    /**
     * {@inheritdoc}
     */
    public function setContext(ContextInterface $context)
    {
        $this->context = $context;
    }

    /**
     * {@inheritdoc}
     */
    public function getPaths(array $existingPaths)
    {
        $themeName = $this->context->getOr('theme');
        if ($themeName) {
            $themePaths = [];

            $themes = $this->getThemesHierarchy($themeName);
            foreach ($themes as $theme) {
                $existingPaths[] = $themePaths[] = $theme->getDirectory();
            }

            $actionName = $this->context->getOr('action');
            if ($actionName) {
                foreach ($themePaths as $path) {
                    $existingPaths[] = implode(self::DELIMITER, [$path, $actionName]);
                }
            }

            $routeName = $this->context->getOr('route_name');
            if ($routeName) {
                foreach ($themePaths as $path) {
                    $existingPaths[] = implode(self::DELIMITER, [$path, $routeName]);
                }
            }

            $pageTemplate = $this->context->getOr('page_template');
            if ($pageTemplate) {
                $theme = $this->themeManager->getTheme($themeName);
                if ($theme->getPageTemplate($this->context->getOr('page_template'), $routeName)) {
                    foreach ($themePaths as $path) {
                        $existingPaths[] =
                            implode(self::DELIMITER, [$path, $routeName, 'page_template', $pageTemplate]);
                    }
                }
            }
        }

        return $existingPaths;
    }

    /**
     * Returns theme inheritance hierarchy with root theme as first item
     *
     * @param string $themeName
     *
     * @return Theme[]
     */
    protected function getThemesHierarchy($themeName)
    {
        $hierarchy = [];

        while (null !== $themeName) {
            $theme = $this->themeManager->getTheme($themeName);

            $hierarchy[] = $theme;
            $themeName   = $theme->getParentTheme();
        }

        return array_reverse($hierarchy);
    }
}
