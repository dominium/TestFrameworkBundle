<?php

namespace Labudzinski\TestFrameworkBundle\BehatStatisticExtension\AvgTimeProvider;

class SimpleAvgProvider extends AbstractAvgTimeProvider
{
    protected function calculate()
    {
        $this->averageTimeTable = $this->repository->getAverageTimeTable([]);
        $this->calculateAverageTime();
    }
}
