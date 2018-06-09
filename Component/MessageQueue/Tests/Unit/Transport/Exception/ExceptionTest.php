<?php
namespace Labudzinski\TestFrameworkBundle\Component\MessageQueue\Tests\Unit\Transport\Exception;

use Labudzinski\TestFrameworkBundle\Component\MessageQueue\Transport\Exception\Exception;
use Labudzinski\TestFrameworkBundle\Component\MessageQueue\Transport\Exception\ExceptionInterface;
use Labudzinski\TestFrameworkBundle\Component\Testing\ClassExtensionTrait;

class ExceptionTest extends \PHPUnit_Framework_TestCase
{
    use ClassExtensionTrait;
    
    public function testShouldBeSubClassOfException()
    {
        $this->assertClassExtends(\Exception::class, Exception::class);
    }

    public function testShouldImplementExceptionInterface()
    {
        $this->assertClassImplements(ExceptionInterface::class, Exception::class);
    }

    public function testCouldBeConstructedWithoutAnyArguments()
    {
        new Exception();
    }
}
