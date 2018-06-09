<?php

namespace Labudzinski\TestFrameworkBundle\Component\ChainProcessor\Tests\Unit;

use Labudzinski\TestFrameworkBundle\Component\ChainProcessor\ApplicableCheckerInterface;
use Labudzinski\TestFrameworkBundle\Component\ChainProcessor\ContextInterface;

class NotDisabledApplicableChecker implements ApplicableCheckerInterface
{
    /**
     * {@inheritdoc}
     */
    public function isApplicable(ContextInterface $context, array $processorAttributes)
    {
        $result = self::ABSTAIN;
        if (isset($processorAttributes['disabled']) && $processorAttributes['disabled']) {
            $result = self::NOT_APPLICABLE;
        }

        return $result;
    }
}
