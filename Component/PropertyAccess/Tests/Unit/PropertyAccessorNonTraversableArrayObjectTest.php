<?php

namespace Labudzinski\TestFrameworkBundle\Component\PropertyAccess\Tests\Unit;

use Labudzinski\TestFrameworkBundle\Component\PropertyAccess\Tests\Unit\Fixtures\NonTraversableArrayObject;

class PropertyAccessorNonTraversableArrayObjectTest extends PropertyAccessorArrayAccessTest
{
    protected function getContainer(array $array)
    {
        return new NonTraversableArrayObject($array);
    }
}
