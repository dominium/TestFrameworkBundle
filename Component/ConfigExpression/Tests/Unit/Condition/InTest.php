<?php

namespace Labudzinski\TestFrameworkBundle\Component\ConfigExpression\Tests\Unit\Condition;

use Labudzinski\TestFrameworkBundle\Component\ConfigExpression\Condition;
use Labudzinski\TestFrameworkBundle\Component\ConfigExpression\ContextAccessor;
use Symfony\Component\PropertyAccess\PropertyPath;

class InTest extends \PHPUnit_Framework_TestCase
{
    protected $condition;

    public function setUp()
    {
        $this->condition = new Condition\In();
        $this->condition->setContextAccessor(new ContextAccessor());
    }

    /**
     * @dataProvider evaluateDataProvider
     */
    public function testEvaluate(array $options, $context, $expectedResult)
    {
        $this->assertSame($this->condition, $this->condition->initialize($options));
        $this->assertEquals($expectedResult, $this->condition->evaluate($context));
    }

    public function evaluateDataProvider()
    {
        $options = ['left' => new PropertyPath('foo'), 'right' => new PropertyPath('bar')];

        return [
            'in_array' => [
                'options'        => $options,
                'context'        => ['foo' => 'word', 'bar' => ['sth', 'word', 'sth else']],
                'expectedResult' => true
            ],
            'not_in_array' => [
                'options'        => $options,
                'context'        => ['foo' => 'word', 'bar' => ['sth', 'words', 'sth else']],
                'expectedResult' => false,
            ],
        ];
    }
}
