<?php

namespace Labudzinski\TestFrameworkBundle\BehatStatisticExtension\AvgTimeProvider;

use Labudzinski\TestFrameworkBundle\BehatStatisticExtension\Repository\StatisticRepository;

interface StatisticRepositoryAwareInterface
{
    /**
     * @param StatisticRepository $repository
     */
    public function setRepository(StatisticRepository $repository);
}
