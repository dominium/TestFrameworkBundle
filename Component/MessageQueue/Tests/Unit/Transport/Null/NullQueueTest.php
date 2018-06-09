<?php
namespace Labudzinski\TestFrameworkBundle\Component\MessageQueue\Tests\Unit\Transport\Null;

use Labudzinski\TestFrameworkBundle\Component\MessageQueue\Transport\Null\NullQueue;
use Labudzinski\TestFrameworkBundle\Component\MessageQueue\Transport\QueueInterface;
use Labudzinski\TestFrameworkBundle\Component\Testing\ClassExtensionTrait;

class NullQueueTest extends \PHPUnit_Framework_TestCase
{
    use ClassExtensionTrait;

    public function testShouldImplementQueueInterface()
    {
        $this->assertClassImplements(QueueInterface::class, NullQueue::class);
    }

    public function testCouldBeConstructedWithNameAsArgument()
    {
        new NullQueue('aName');
    }

    public function testShouldAllowGetNameSetInConstructor()
    {
        $queue = new NullQueue('theName');

        $this->assertEquals('theName', $queue->getQueueName());
    }
}
