<?php

namespace Labudzinski\TestFrameworkBundle\Component\ConfigExpression\Tests\Integration;

use Labudzinski\TestFrameworkBundle\Component\ConfigExpression\ConfigExpressions;
use Labudzinski\TestFrameworkBundle\Component\ConfigExpression\ExpressionAssembler;

class ExpressionAssemblerTest extends \PHPUnit_Framework_TestCase
{
    /** @var ExpressionAssembler */
    protected $expressionAssembler;

    public function setUp()
    {
        $configExpressions = new ConfigExpressions();
        $this->expressionAssembler = $configExpressions->getAssembler();
    }

    /**
     * @dataProvider assembleDataProvider
     */
    public function testAssemble(array $configuration)
    {
        $expr = $this->expressionAssembler->assemble($configuration);
        $this->assertEquals($configuration, $expr->toArray());
    }

    public function assembleDataProvider()
    {
        return [
            [
                [
                    '@and' => [
                        'parameters' => [
                            [
                                '@or' => [
                                    'parameters' => [
                                        [
                                            '@empty' => [
                                                'parameters' => [
                                                    '$field',
                                                ],
                                            ],
                                        ],
                                        [
                                            '@contains' => [
                                                'parameters' => [
                                                    '$field2', 'value'
                                                ],
                                            ],
                                        ],
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ],
            [
                [
                    '@and' => [
                        'parameters' => [
                            [
                                '@or' => [
                                    'parameters' => [
                                        [
                                            '@empty' => [
                                                'parameters' => [
                                                    '$field'
                                                ],
                                            ],
                                        ],
                                    ],
                                ],
                            ],
                            [
                                '@or' => [
                                    'parameters' => [
                                        [
                                            '@contains' => [
                                                'parameters' => [
                                                    '$field2', 'value'
                                                ],
                                            ],
                                        ],
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ];
    }
}
