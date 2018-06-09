<?php

namespace Labudzinski\TestFrameworkBundle\Component\PropertyAccess\Tests\Unit;

use Labudzinski\TestFrameworkBundle\Component\PropertyAccess\Tests\Unit\Fixtures\TraversableArrayObject;

class PropertyAccessorTraversableArrayObjectTest extends PropertyAccessorCollectionTest
{
    protected function getContainer(array $array)
    {
        return new TraversableArrayObject($array);
    }
}
