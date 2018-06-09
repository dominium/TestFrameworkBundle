<?php
namespace Labudzinski\TestFrameworkBundle\Component\MessageQueue\Tests\Unit\Client;

use Doctrine\DBAL\Connection;
use Labudzinski\TestFrameworkBundle\Component\MessageQueue\Client\Config;
use Labudzinski\TestFrameworkBundle\Component\MessageQueue\Client\DbalDriver;
use Labudzinski\TestFrameworkBundle\Component\MessageQueue\Client\DriverFactory;
use Labudzinski\TestFrameworkBundle\Component\MessageQueue\Client\NullDriver;
use Labudzinski\TestFrameworkBundle\Component\MessageQueue\Transport\ConnectionInterface;
use Labudzinski\TestFrameworkBundle\Component\MessageQueue\Transport\Dbal\DbalConnection;
use Labudzinski\TestFrameworkBundle\Component\MessageQueue\Transport\Dbal\DbalSession;
use Labudzinski\TestFrameworkBundle\Component\MessageQueue\Transport\Null\NullConnection;
use Labudzinski\TestFrameworkBundle\Component\MessageQueue\Transport\Null\NullSession;

class DriverFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testShouldCreateNullSessionInstance()
    {
        $config = new Config('', '', '', '');
        $connection = new NullConnection();

        $factory = new DriverFactory([NullConnection::class => NullDriver::class]);
        $driver = $factory->create($connection, $config);

        self::assertInstanceOf(NullDriver::class, $driver);
        self::assertAttributeInstanceOf(NullSession::class, 'session', $driver);
        self::assertAttributeSame($config, 'config', $driver);
    }

    public function testShouldCreateDbalSessionInstance()
    {
        $config = new Config('', '', '', '');

        $doctrineConnection = $this->createMock(Connection::class);
        $connection = new DbalConnection($doctrineConnection, 'aTableName');

        $factory = new DriverFactory([DbalConnection::class => DbalDriver::class]);
        $driver = $factory->create($connection, $config);

        self::assertInstanceOf(DbalDriver::class, $driver);
        self::assertAttributeInstanceOf(DbalSession::class, 'session', $driver);
        self::assertAttributeSame($config, 'config', $driver);
    }

    public function testShouldThrowExceptionIfUnexpectedConnectionInstance()
    {
        $factory = new DriverFactory([]);

        $this->expectException(\LogicException::class);
        $this->expectExceptionMessage('Unexpected connection instance: "Mock_Connection');
        $factory->create($this->createMock(ConnectionInterface::class), new Config('', '', '', ''));
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|NullSession
     */
    protected function createNullSessionMock()
    {
        return $this->createMock(NullSession::class, [], [], '', false);
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|NullConnection
     */
    protected function createNullConnectionMock()
    {
        return $this->createMock(NullConnection::class);
    }
}
