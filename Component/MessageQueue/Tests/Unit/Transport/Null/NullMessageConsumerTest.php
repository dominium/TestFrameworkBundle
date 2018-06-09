<?php
namespace Labudzinski\TestFrameworkBundle\Component\MessageQueue\Tests\Unit\Transport\Null;

use Labudzinski\TestFrameworkBundle\Component\MessageQueue\Transport\MessageConsumerInterface;
use Labudzinski\TestFrameworkBundle\Component\MessageQueue\Transport\Null\NullMessage;
use Labudzinski\TestFrameworkBundle\Component\MessageQueue\Transport\Null\NullMessageConsumer;
use Labudzinski\TestFrameworkBundle\Component\MessageQueue\Transport\Null\NullQueue;
use Labudzinski\TestFrameworkBundle\Component\Testing\ClassExtensionTrait;

class NullMessageConsumerTest extends \PHPUnit_Framework_TestCase
{
    use ClassExtensionTrait;

    public function testShouldImplementMessageConsumerInterface()
    {
        $this->assertClassImplements(MessageConsumerInterface::class, NullMessageConsumer::class);
    }

    public function testCouldBeConstructedWithQueueAsArgument()
    {
        new NullMessageConsumer(new NullQueue('aName'));
    }

    public function testShouldAlwaysReturnNullOnReceive()
    {
        $consumer = new NullMessageConsumer(new NullQueue('theQueueName'));

        $this->assertNull($consumer->receive());
        $this->assertNull($consumer->receive());
        $this->assertNull($consumer->receive());
    }

    public function testShouldAlwaysReturnNullOnReceiveNoWait()
    {
        $consumer = new NullMessageConsumer(new NullQueue('theQueueName'));

        $this->assertNull($consumer->receiveNoWait());
        $this->assertNull($consumer->receiveNoWait());
        $this->assertNull($consumer->receiveNoWait());
    }

    public function testShouldDoNothingOnAcknowledge()
    {
        $consumer = new NullMessageConsumer(new NullQueue('theQueueName'));

        $consumer->acknowledge(new NullMessage());
    }

    public function testShouldDoNothingOnReject()
    {
        $consumer = new NullMessageConsumer(new NullQueue('theQueueName'));

        $consumer->reject(new NullMessage());
    }
}
