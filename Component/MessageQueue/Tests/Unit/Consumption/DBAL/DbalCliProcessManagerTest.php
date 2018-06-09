<?php
namespace Labudzinski\TestFrameworkBundle\Component\MessageQueue\Tests\Unit\Consumption\DBAL;

use Labudzinski\TestFrameworkBundle\Component\MessageQueue\Consumption\Dbal\DbalCliProcessManager;

class DbalCliProcessManagerTest extends \PHPUnit_Framework_TestCase
{
    public function testShouldReturnListOfProcessesPids()
    {
        $processManager = new DbalCliProcessManager();

        $pids = $processManager->getListOfProcessesPids('');

        $this->assertGreaterThan(0, count($pids));
        $this->assertInternalType('integer', $pids[0]);
    }
}
