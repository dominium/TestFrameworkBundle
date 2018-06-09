<?php
namespace Labudzinski\TestFrameworkBundle\Component\MessageQueue\Tests\Unit\Consumption;

use Labudzinski\TestFrameworkBundle\Component\MessageQueue\Consumption\AbstractExtension;
use Labudzinski\TestFrameworkBundle\Component\MessageQueue\Consumption\ExtensionInterface;
use Labudzinski\TestFrameworkBundle\Component\Testing\ClassExtensionTrait;

class AbstractExtensionTest extends \PHPUnit_Framework_TestCase
{
    use ClassExtensionTrait;

    public function testShouldImplementExtensionInterface()
    {
        $this->assertClassImplements(ExtensionInterface::class, AbstractExtension::class);
    }
}
