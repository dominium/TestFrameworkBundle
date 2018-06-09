<?php
namespace Labudzinski\TestFrameworkBundle\Component\MessageQueue\Tests\Unit\Transport\Exception;

use Labudzinski\TestFrameworkBundle\Component\MessageQueue\Tests\Unit\Mock\DestinationBar;
use Labudzinski\TestFrameworkBundle\Component\MessageQueue\Tests\Unit\Mock\DestinationFoo;
use Labudzinski\TestFrameworkBundle\Component\MessageQueue\Transport\Exception\Exception as ExceptionInterface;
use Labudzinski\TestFrameworkBundle\Component\MessageQueue\Transport\Exception\InvalidDestinationException;
use Labudzinski\TestFrameworkBundle\Component\Testing\ClassExtensionTrait;

class InvalidDestinationExceptionTest extends \PHPUnit_Framework_TestCase
{
    use ClassExtensionTrait;
    
    public function testShouldBeSubClassOfException()
    {
        $this->assertClassExtends(ExceptionInterface::class, InvalidDestinationException::class);
    }

    public function testCouldBeConstructedWithoutAnyArguments()
    {
        new InvalidDestinationException();
    }

    public function testThrowIfAssertDestinationInstanceOfNotSameAsExpected()
    {
        $this->expectException(InvalidDestinationException::class);
        $this->expectExceptionMessage(
            'The destination must be an instance of Labudzinski\TestFrameworkBundle\Component\MessageQueue\Tests\Unit\Mock\DestinationBar'.
            ' but it is Labudzinski\TestFrameworkBundle\Component\MessageQueue\Tests\Unit\Mock\DestinationFoo.'
        );

        InvalidDestinationException::assertDestinationInstanceOf(new DestinationFoo(), DestinationBar::class);
    }

    public function testShouldDoNothingIfAssertDestinationInstanceOfSameAsExpected()
    {
        InvalidDestinationException::assertDestinationInstanceOf(new DestinationFoo(), DestinationFoo::class);
    }
}
