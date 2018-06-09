<?php
namespace Labudzinski\TestFrameworkBundle\Component\MessageQueue\Tests\Unit\Consumption;

use Labudzinski\TestFrameworkBundle\Component\MessageQueue\Consumption\Exception\ExceptionInterface;
use Labudzinski\TestFrameworkBundle\Component\MessageQueue\Consumption\Exception\LogicException;
use Labudzinski\TestFrameworkBundle\Component\Testing\ClassExtensionTrait;

class LogicExceptionTest extends \PHPUnit_Framework_TestCase
{
    use ClassExtensionTrait;
    
    public function testShouldImplementExceptionInterface()
    {
        $this->assertClassImplements(ExceptionInterface::class, LogicException::class);
    }

    public function testShouldExtendLogicException()
    {
        $this->assertClassExtends(\LogicException::class, LogicException::class);
    }
    
    public function testCouldBeConstructedWithoutAnyArguments()
    {
        new LogicException();
    }
}
