<?php
namespace Labudzinski\TestFrameworkBundle\Component\MessageQueue\Tests\Unit\Transport\Null;

use Labudzinski\TestFrameworkBundle\Component\MessageQueue\Transport\MessageProducerInterface;
use Labudzinski\TestFrameworkBundle\Component\MessageQueue\Transport\Null\NullMessage;
use Labudzinski\TestFrameworkBundle\Component\MessageQueue\Transport\Null\NullMessageProducer;
use Labudzinski\TestFrameworkBundle\Component\MessageQueue\Transport\Null\NullTopic;
use Labudzinski\TestFrameworkBundle\Component\Testing\ClassExtensionTrait;

class NullMessageProducerTest extends \PHPUnit_Framework_TestCase
{
    use ClassExtensionTrait;

    public function testShouldImplementMessageProducerInterface()
    {
        $this->assertClassImplements(MessageProducerInterface::class, NullMessageProducer::class);
    }

    public function testCouldBeConstructedWithoutAnyArguments()
    {
        new NullMessageProducer();
    }

    public function testShouldDoNothingOnSend()
    {
        $producer = new NullMessageProducer();

        $producer->send(new NullTopic('aName'), new NullMessage());
    }
}
