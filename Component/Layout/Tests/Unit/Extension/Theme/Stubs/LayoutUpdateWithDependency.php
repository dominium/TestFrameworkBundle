<?php

namespace Labudzinski\TestFrameworkBundle\Component\Layout\Tests\Unit\Extension\Theme\Stubs;

use Labudzinski\TestFrameworkBundle\Component\Layout\LayoutUpdateInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;

interface LayoutUpdateWithDependency extends LayoutUpdateInterface, ContainerAwareInterface
{
}
