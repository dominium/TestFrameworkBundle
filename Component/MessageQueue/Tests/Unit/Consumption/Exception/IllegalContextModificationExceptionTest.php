<?php
namespace Labudzinski\TestFrameworkBundle\Component\MessageQueue\Tests\Unit\Consumption;

use Labudzinski\TestFrameworkBundle\Component\MessageQueue\Consumption\Exception\ExceptionInterface;
use Labudzinski\TestFrameworkBundle\Component\MessageQueue\Consumption\Exception\IllegalContextModificationException;
use Labudzinski\TestFrameworkBundle\Component\Testing\ClassExtensionTrait;

class IllegalContextModificationExceptionTest extends \PHPUnit_Framework_TestCase
{
    use ClassExtensionTrait;
    
    public function testShouldImplementExceptionInterface()
    {
        $this->assertClassImplements(ExceptionInterface::class, IllegalContextModificationException::class);
    }

    public function testShouldExtendLogicException()
    {
        $this->assertClassExtends(\LogicException::class, IllegalContextModificationException::class);
    }
    
    public function testCouldBeConstructedWithoutAnyArguments()
    {
        new IllegalContextModificationException();
    }
}
