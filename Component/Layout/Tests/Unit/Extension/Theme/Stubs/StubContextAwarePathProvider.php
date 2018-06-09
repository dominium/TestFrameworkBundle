<?php

namespace Labudzinski\TestFrameworkBundle\Component\Layout\Tests\Unit\Extension\Theme\Stubs;

use Labudzinski\TestFrameworkBundle\Component\Layout\ContextAwareInterface;
use Labudzinski\TestFrameworkBundle\Component\Layout\Extension\Theme\PathProvider\PathProviderInterface;

interface StubContextAwarePathProvider extends PathProviderInterface, ContextAwareInterface
{
}
