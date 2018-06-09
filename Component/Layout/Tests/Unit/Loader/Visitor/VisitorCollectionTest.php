<?php

namespace Labudzinski\TestFrameworkBundle\Component\Layout\Tests\Unit\Loader\Visitor;

use Labudzinski\TestFrameworkBundle\Component\Layout\Loader\Visitor\VisitorCollection;

class VisitorCollectionTest extends \PHPUnit_Framework_TestCase
{
    public function testShouldValidateConstructParameters()
    {
        $this->expectException('\Labudzinski\TestFrameworkBundle\Component\Layout\Exception\UnexpectedTypeException');
        $this->expectExceptionMessage(
            'Expected argument of type "Labudzinski\TestFrameworkBundle\Component\Layout\Loader\Visitor\VisitorInterface",'
            . ' "stdClass" given.'
        );
        new VisitorCollection([new \stdClass()]);
    }

    public function testShouldAcceptValidConditionsAsConstructorParameters()
    {
        $collection = new VisitorCollection(
            [$this->createMock('Labudzinski\TestFrameworkBundle\Component\Layout\Loader\Visitor\VisitorInterface')]
        );

        $this->assertNotEmpty($collection);
    }

    public function testAppendShouldValidateParameter()
    {
        $this->expectException('\Labudzinski\TestFrameworkBundle\Component\Layout\Exception\UnexpectedTypeException');
        $this->expectExceptionMessage(
            'Expected argument of type "Labudzinski\TestFrameworkBundle\Component\Layout\Loader\Visitor\VisitorInterface",'
            . ' "stdClass" given.'
        );

        $collection = new VisitorCollection();
        $collection->append(new \stdClass());
    }

    public function testAppendShouldAcceptValidCondition()
    {
        $collection = new VisitorCollection();
        $this->assertEmpty($collection);

        $collection->append($this->createMock('Labudzinski\TestFrameworkBundle\Component\Layout\Loader\Visitor\VisitorInterface'));

        $this->assertNotEmpty($collection);
    }
}
