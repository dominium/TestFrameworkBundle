<?php

namespace Labudzinski\TestFrameworkBundle\Behat\HealthChecker;

interface HealthCheckerAwareInterface
{
    /**
     * @param HealthCheckerInterface $healthChecker
     */
    public function addHealthChecker(HealthCheckerInterface $healthChecker);
}
