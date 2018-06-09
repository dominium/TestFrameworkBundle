<?php

namespace Labudzinski\TestFrameworkBundle\Component\Duplicator\Filter;

use DeepCopy\Filter\Filter as BaseFilter;
use Labudzinski\TestFrameworkBundle\Component\Duplicator\AbstractFactory;
use Labudzinski\TestFrameworkBundle\Component\Duplicator\ObjectType;

/**
 * @method BaseFilter create(ObjectType $objectType)
 */
class FilterFactory extends AbstractFactory
{
    /**
     * @return string
     */
    protected function getSupportedClassName()
    {
        return '\DeepCopy\Filter\Filter';
    }
}
