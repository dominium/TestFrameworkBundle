<?php
namespace Labudzinski\TestFrameworkBundle\Component\MessageQueue\Tests\Unit\Transport\Null;

use Labudzinski\TestFrameworkBundle\Component\MessageQueue\Transport\ConnectionInterface;
use Labudzinski\TestFrameworkBundle\Component\MessageQueue\Transport\Null\NullConnection;
use Labudzinski\TestFrameworkBundle\Component\MessageQueue\Transport\Null\NullSession;
use Labudzinski\TestFrameworkBundle\Component\Testing\ClassExtensionTrait;

class NullConnectionTest extends \PHPUnit_Framework_TestCase
{
    use ClassExtensionTrait;

    public function testShouldImplementConnectionInterface()
    {
        $this->assertClassImplements(ConnectionInterface::class, NullConnection::class);
    }
    
    public function testCouldBeConstructedWithoutAnyArguments()
    {
        new NullConnection();
    }
    
    public function testShouldCreateNullSession()
    {
        $connection = new NullConnection();

        $this->assertInstanceOf(NullSession::class, $connection->createSession());
    }
}
