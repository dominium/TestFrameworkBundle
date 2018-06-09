<?php

namespace Labudzinski\TestFrameworkBundle\Component\Layout\Tests\Unit;

use Labudzinski\TestFrameworkBundle\Component\Layout\Block\Type\BaseType;
use Labudzinski\TestFrameworkBundle\Component\Layout\Layouts;

class LayoutsTest extends \PHPUnit_Framework_TestCase
{
    public function testCoreExtensionIsAdded()
    {
        $this->assertInstanceOf(
            'Labudzinski\TestFrameworkBundle\Component\Layout\Block\Type\BaseType',
            Layouts::createLayoutFactory()->getType(BaseType::NAME)
        );
    }
}
