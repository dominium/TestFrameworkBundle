<?php
namespace Labudzinski\TestFrameworkBundle\Component\MessageQueue\Provider;

class NullJobConfigurationProvider implements JobConfigurationProviderInterface
{
    /**
     * {@inheritdoc}
     */
    public function getTimeBeforeStaleForJobName($jobName)
    {
        return null;
    }
}
