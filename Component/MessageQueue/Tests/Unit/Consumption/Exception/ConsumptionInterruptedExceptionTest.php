<?php
namespace Labudzinski\TestFrameworkBundle\Component\MessageQueue\Tests\Unit\Consumption;

use Labudzinski\TestFrameworkBundle\Component\MessageQueue\Consumption\Exception\ConsumptionInterruptedException;
use Labudzinski\TestFrameworkBundle\Component\MessageQueue\Consumption\Exception\ExceptionInterface;
use Labudzinski\TestFrameworkBundle\Component\Testing\ClassExtensionTrait;

class ConsumptionInterruptedExceptionTest extends \PHPUnit_Framework_TestCase
{
    use ClassExtensionTrait;
    
    public function testShouldImplementExceptionInterface()
    {
        $this->assertClassImplements(ExceptionInterface::class, ConsumptionInterruptedException::class);
    }

    public function testShouldExtendLogicException()
    {
        $this->assertClassExtends(\LogicException::class, ConsumptionInterruptedException::class);
    }
    
    public function testCouldBeConstructedWithoutAnyArguments()
    {
        new ConsumptionInterruptedException();
    }
}
