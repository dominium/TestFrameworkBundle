<?php
namespace Labudzinski\TestFrameworkBundle\Component\MessageQueue\Tests\Unit\Transport\Null;

use Labudzinski\TestFrameworkBundle\Component\MessageQueue\Transport\Null\NullTopic;
use Labudzinski\TestFrameworkBundle\Component\MessageQueue\Transport\TopicInterface;
use Labudzinski\TestFrameworkBundle\Component\Testing\ClassExtensionTrait;

class NullTopicTest extends \PHPUnit_Framework_TestCase
{
    use ClassExtensionTrait;

    public function testShouldImplementTopicInterface()
    {
        $this->assertClassImplements(TopicInterface::class, NullTopic::class);
    }

    public function testCouldBeConstructedWithNameAsArgument()
    {
        new NullTopic('aName');
    }

    public function testShouldAllowGetNameSetInConstructor()
    {
        $topic = new NullTopic('theName');

        $this->assertEquals('theName', $topic->getTopicName());
    }
}
