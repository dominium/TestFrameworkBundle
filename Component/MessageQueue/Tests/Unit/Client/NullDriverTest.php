<?php
namespace Labudzinski\TestFrameworkBundle\Component\MessageQueue\Tests\Unit\Client;

use Labudzinski\TestFrameworkBundle\Component\MessageQueue\Client\Config;
use Labudzinski\TestFrameworkBundle\Component\MessageQueue\Client\Message;
use Labudzinski\TestFrameworkBundle\Component\MessageQueue\Client\MessagePriority;
use Labudzinski\TestFrameworkBundle\Component\MessageQueue\Client\NullDriver;
use Labudzinski\TestFrameworkBundle\Component\MessageQueue\Transport\Null\NullMessage;
use Labudzinski\TestFrameworkBundle\Component\MessageQueue\Transport\Null\NullMessageProducer;
use Labudzinski\TestFrameworkBundle\Component\MessageQueue\Transport\Null\NullQueue;
use Labudzinski\TestFrameworkBundle\Component\MessageQueue\Transport\Null\NullSession;

class NullDriverTest extends \PHPUnit_Framework_TestCase
{
    public function testCouldBeConstructedWithRequiredArguments()
    {
        new NullDriver(new NullSession(), new Config('', '', '', '', ''));
    }

    public function testShouldSendJustCreatedMessageToQueue()
    {
        $config = new Config('', '', '', '', '');
        $queue = new NullQueue('aQueue');

        $transportMessage = new NullMessage();

        $producer = $this->createMessageProducer();
        $producer
            ->expects(self::once())
            ->method('send')
            ->with(self::identicalTo($queue), self::identicalTo($transportMessage))
        ;

        $session = $this->createSessionStub($transportMessage, $producer);

        $driver = new NullDriver($session, $config);

        $driver->send($queue, new Message());
    }

    public function testShouldConvertClientMessageToTransportMessage()
    {
        $config = new Config('', '', '', '', '');
        $queue = new NullQueue('aQueue');

        $message = new Message();
        $message->setBody('theBody');
        $message->setContentType('theContentType');
        $message->setMessageId('theMessageId');
        $message->setTimestamp(12345);
        $message->setDelay(123);
        $message->setExpire(345);
        $message->setPriority(MessagePriority::LOW);
        $message->setHeaders(['theHeaderFoo' => 'theFoo']);
        $message->setProperties(['thePropertyBar' => 'theBar']);

        $transportMessage = new NullMessage();

        $producer = $this->createMessageProducer();
        $producer
            ->expects(self::once())
            ->method('send')
        ;

        $session = $this->createSessionStub($transportMessage, $producer);

        $driver = new NullDriver($session, $config);

        $driver->send($queue, $message);

        self::assertSame('theBody', $transportMessage->getBody());
        self::assertSame([
            'theHeaderFoo' => 'theFoo',
            'content_type' => 'theContentType',
            'expiration' => 345,
            'delay' => 123,
            'priority' => MessagePriority::LOW,
        ], $transportMessage->getHeaders());
        self::assertSame([
            'thePropertyBar' => 'theBar',
        ], $transportMessage->getProperties());
    }

    public function testShouldReturnConfigInstance()
    {
        $config = new Config('', '', '', '', '');

        $driver = new NullDriver($this->createSessionStub(), $config);
        $result = $driver->getConfig();

        self::assertSame($config, $result);
    }

    public function testAllowCreateTransportMessage()
    {
        $config = new Config('', '', '', '', '');

        $message = new NullMessage();

        $session = $this->createSessionMock();
        $session
            ->expects(self::once())
            ->method('createMessage')
            ->willReturn($message)
        ;

        $driver = new NullDriver($session, $config);

        self::assertSame($message, $driver->createTransportMessage());
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|NullSession
     */
    private function createSessionMock()
    {
        return $this->createMock(NullSession::class);
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|NullSession
     */
    private function createSessionStub($message = null, $messageProducer = null)
    {
        $sessionMock = $this->createMock(NullSession::class);
        $sessionMock
            ->expects($this->any())
            ->method('createMessage')
            ->willReturn($message)
        ;
        $sessionMock
            ->expects($this->any())
            ->method('createQueue')
            ->willReturnCallback(function ($name) {
                return new NullQueue($name);
            })
        ;
        $sessionMock
            ->expects($this->any())
            ->method('createProducer')
            ->willReturn($messageProducer)
        ;

        return $sessionMock;
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|NullMessageProducer
     */
    private function createMessageProducer()
    {
        return $this->createMock(NullMessageProducer::class);
    }
}
