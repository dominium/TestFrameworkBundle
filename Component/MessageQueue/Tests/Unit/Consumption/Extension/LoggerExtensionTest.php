<?php

namespace Labudzinski\TestFrameworkBundle\Component\MessageQueue\Tests\Unit\Consumption\Extension;

use Labudzinski\TestFrameworkBundle\Component\MessageQueue\Consumption\Context;
use Labudzinski\TestFrameworkBundle\Component\MessageQueue\Consumption\Extension\LoggerExtension;
use Labudzinski\TestFrameworkBundle\Component\MessageQueue\Consumption\ExtensionInterface;
use Labudzinski\TestFrameworkBundle\Component\MessageQueue\Transport\SessionInterface;
use Labudzinski\TestFrameworkBundle\Component\Testing\ClassExtensionTrait;
use Psr\Log\LoggerInterface;

class LoggerExtensionTest extends \PHPUnit_Framework_TestCase
{
    use ClassExtensionTrait;

    public function testShouldImplementExtensionInterface()
    {
        $this->assertClassImplements(ExtensionInterface::class, LoggerExtension::class);
    }

    public function testCouldBeConstructedWithLoggerAsFirstArgument()
    {
        new LoggerExtension($this->createMock(LoggerInterface::class));
    }

    public function testShouldSetLoggerToContextOnStart()
    {
        $logger = $this->createMock(LoggerInterface::class);

        $extension = new LoggerExtension($logger);

        $context = new Context($this->createMock(SessionInterface::class));

        $extension->onStart($context);

        $this->assertSame($logger, $context->getLogger());
    }

    public function testShouldAddInfoMessageOnStart()
    {
        $logger = $this->createMock(LoggerInterface::class);
        $logger->expects($this->once())
            ->method('debug')
            ->with('Set logger to the context');

        $extension = new LoggerExtension($logger);

        $context = new Context($this->createMock(SessionInterface::class));

        $extension->onStart($context);
    }
}
