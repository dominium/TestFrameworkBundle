<?php

namespace Labudzinski\TestFrameworkBundle\Component\DoctrineUtils\Tests\Unit\ORM;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Labudzinski\TestFrameworkBundle\Component\DoctrineUtils\ORM\PlatformResultSetMapping;
use Labudzinski\TestFrameworkBundle\Component\DoctrineUtils\ORM\ResultSetMappingUtil;

class ResultSetMappingUtilTest extends \PHPUnit_Framework_TestCase
{
    public function testCreateResultSetMapping()
    {
        $platform = $this->getMockBuilder(AbstractPlatform::class)
            ->disableOriginalConstructor()
            ->getMockForAbstractClass();

        $this->assertInstanceOf(
            PlatformResultSetMapping::class,
            ResultSetMappingUtil::createResultSetMapping($platform)
        );
    }
}
