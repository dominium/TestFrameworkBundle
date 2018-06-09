<?php

namespace Labudzinski\TestFrameworkBundle\BehatStatisticExtension\Specification\Statistic;

interface StatisticRepositoryInterface
{
    /**
     * @param string $path path to the feature file
     * @return int Time in seconds
     */
    public function getFeatureDuration($path);
}
