<?php

namespace Labudzinski\TestFrameworkBundle\Tests\Unit\Behat\Context\Initializer;

use Labudzinski\TestFrameworkBundle\Behat\Context\Initializer\OroPageObjectInitializer;

class OroPageObjectInitializerTest extends \PHPUnit_Framework_TestCase
{
    public function testInitializeContext()
    {
        $elementFactory = $this
            ->getMockBuilder('Labudzinski\TestFrameworkBundle\Behat\Element\OroElementFactory')
            ->disableOriginalConstructor()
            ->getMock()
        ;
        $pageFactory = $this
            ->getMockBuilder('Labudzinski\TestFrameworkBundle\Behat\Element\OroPageFactory')
            ->disableOriginalConstructor()
            ->getMock()
        ;
        $featureContext = $this->getMockBuilder('Labudzinski\TestFrameworkBundle\Tests\Behat\Context\OroMainContext')
            ->getMock();
        $featureContext->expects($this->once())->method('setElementFactory');

        $initializer = new OroPageObjectInitializer($elementFactory, $pageFactory);
        $initializer->initializeContext($featureContext);
    }
}
