<?php

namespace Labudzinski\TestFrameworkBundle\Component\ChainProcessor\Tests\Unit;

use Labudzinski\TestFrameworkBundle\Component\ChainProcessor\ChainApplicableChecker;
use Labudzinski\TestFrameworkBundle\Component\ChainProcessor\GroupRangeApplicableChecker;
use Labudzinski\TestFrameworkBundle\Component\ChainProcessor\MatchApplicableChecker;
use Labudzinski\TestFrameworkBundle\Component\ChainProcessor\ProcessorApplicableCheckerFactory;
use Labudzinski\TestFrameworkBundle\Component\ChainProcessor\SkipGroupApplicableChecker;

class ProcessorApplicableCheckerFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testCreateApplicableChecker()
    {
        $factory = new ProcessorApplicableCheckerFactory();
        $chainApplicableChecker = $factory->createApplicableChecker();
        self::assertInstanceOf(ChainApplicableChecker::class, $chainApplicableChecker);
        $applicableCheckers = iterator_to_array($chainApplicableChecker);
        self::assertCount(3, $applicableCheckers);
        self::assertInstanceOf(MatchApplicableChecker::class, $applicableCheckers[0]);
        self::assertInstanceOf(SkipGroupApplicableChecker::class, $applicableCheckers[1]);
        self::assertInstanceOf(GroupRangeApplicableChecker::class, $applicableCheckers[2]);
    }
}
