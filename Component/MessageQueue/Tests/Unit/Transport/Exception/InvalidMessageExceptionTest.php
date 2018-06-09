<?php
namespace Labudzinski\TestFrameworkBundle\Component\MessageQueue\Tests\Unit\Transport\Exception;

use Labudzinski\TestFrameworkBundle\Component\MessageQueue\Transport\Exception\Exception as ExceptionInterface;
use Labudzinski\TestFrameworkBundle\Component\MessageQueue\Transport\Exception\InvalidMessageException;
use Labudzinski\TestFrameworkBundle\Component\Testing\ClassExtensionTrait;

class InvalidMessageExceptionTest extends \PHPUnit_Framework_TestCase
{
    use ClassExtensionTrait;

    public function testShouldBeSubClassOfException()
    {
        $this->assertClassExtends(ExceptionInterface::class, InvalidMessageException::class);
    }

    public function testCouldBeConstructedWithoutAnyArguments()
    {
        new InvalidMessageException();
    }
}
