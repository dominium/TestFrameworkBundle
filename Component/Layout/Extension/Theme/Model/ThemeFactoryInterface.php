<?php

namespace Labudzinski\TestFrameworkBundle\Component\Layout\Extension\Theme\Model;

interface ThemeFactoryInterface
{
    /**
     * @param string $themeName
     * @param array  $themeDefinition
     *
     * @return Theme
     */
    public function create($themeName, array $themeDefinition);
}
