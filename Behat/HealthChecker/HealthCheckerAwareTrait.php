<?php

namespace Labudzinski\TestFrameworkBundle\Behat\HealthChecker;

trait HealthCheckerAwareTrait
{
    /**
     * @var HealthCheckerInterface[]
     */
    protected $healthCheckers = [];

    /**
     * @param HealthCheckerInterface $healthChecker
     */
    public function addHealthChecker(HealthCheckerInterface $healthChecker)
    {
        $this->healthCheckers[] = $healthChecker;
    }
}
