<?php

namespace Labudzinski\TestFrameworkBundle\Component\Layout\Extension\Core;

use Labudzinski\TestFrameworkBundle\Component\Layout\Block\Extension as TypeExtension;
use Labudzinski\TestFrameworkBundle\Component\Layout\Block\Type;
use Labudzinski\TestFrameworkBundle\Component\Layout\Extension\AbstractExtension;

class CoreExtension extends AbstractExtension
{
    /**
     * {@inheritdoc}
     */
    protected function loadTypes()
    {
        return [
            new Type\BaseType(),
            new Type\ContainerType()
        ];
    }

    /**
     * {@inheritdoc}
     */
    protected function loadTypeExtensions()
    {
        return [
            new TypeExtension\ClassAttributeExtension()
        ];
    }
}
