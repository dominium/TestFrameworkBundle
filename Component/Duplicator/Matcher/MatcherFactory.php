<?php

namespace Labudzinski\TestFrameworkBundle\Component\Duplicator\Matcher;

use DeepCopy\Matcher\Matcher as BaseMatcher;
use Labudzinski\TestFrameworkBundle\Component\Duplicator\AbstractFactory;
use Labudzinski\TestFrameworkBundle\Component\Duplicator\ObjectType;

/**
 * @method BaseMatcher create(ObjectType $objectType)
 */
class MatcherFactory extends AbstractFactory
{
    /**
     * @return string
     */
    protected function getSupportedClassName()
    {
        return '\DeepCopy\Matcher\Matcher';
    }
}
