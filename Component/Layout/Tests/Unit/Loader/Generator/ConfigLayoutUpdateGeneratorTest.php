<?php

namespace Labudzinski\TestFrameworkBundle\Component\Layout\Tests\Unit\Loader\Generator;

use Labudzinski\TestFrameworkBundle\Component\Layout\Loader\Generator\ConfigLayoutUpdateGenerator;
use Labudzinski\TestFrameworkBundle\Component\Layout\Loader\Generator\ConfigLayoutUpdateGeneratorExtensionInterface;
use Labudzinski\TestFrameworkBundle\Component\Layout\Loader\Generator\GeneratorData;

class ConfigLayoutUpdateGeneratorTest extends \PHPUnit_Framework_TestCase
{
    /** @var ConfigLayoutUpdateGenerator */
    protected $generator;

    protected function setUp()
    {
        $this->generator = new ConfigLayoutUpdateGenerator();
    }

    protected function tearDown()
    {
        unset($this->generator);
    }

    public function testShouldCallExtensions()
    {
        $source = ['actions' => []];

        /** @var ConfigLayoutUpdateGeneratorExtensionInterface|\PHPUnit_Framework_MockObject_MockObject $extension */
        $extension = $this->createMock(
            'Labudzinski\TestFrameworkBundle\Component\Layout\Loader\Generator\ConfigLayoutUpdateGeneratorExtensionInterface'
        );
        $this->generator->addExtension($extension);

        $extension->expects($this->once())
            ->method('prepare')
            ->with(
                new GeneratorData($source),
                $this->isInstanceOf('Labudzinski\TestFrameworkBundle\Component\Layout\Loader\Visitor\VisitorCollection')
            );

        $this->generator->generate('testClassName', new GeneratorData($source));
    }

    /**
     * @dataProvider resourceDataProvider
     *
     * @param mixed $data
     * @param bool  $exception
     */
    public function testShouldValidateData($data, $exception = false)
    {
        if (false !== $exception) {
            $this->expectException('\Labudzinski\TestFrameworkBundle\Component\Layout\Exception\SyntaxException');
            $this->expectExceptionMessage($exception);
        }

        $this->generator->generate('testClassName', new GeneratorData($data));
    }

    /**
     * @return array
     */
    public function resourceDataProvider()
    {
        return [
            'invalid data'                                                   => [
                '$data'      => new \stdClass(),
                '$exception' => 'Syntax error: expected array with "actions" node at "."'
            ],
            'should contains actions'                                        => [
                '$data'      => [],
                '$exception' => 'Syntax error: expected array with "actions" node at "."'
            ],
            'should contains known actions'                                  => [
                '$data'      => [
                    'actions' => [
                        ['@addSuperPuper' => null]
                    ]
                ],
                '$exception' => 'Syntax error: unknown action "addSuperPuper", '
                    . 'should be one of LayoutManipulatorInterface\'s methods at "actions.0"'
            ],
            'should contains array with action definition in actions'        => [
                '$data'      => [
                    'actions' => ['some string']
                ],
                '$exception' => 'Syntax error: expected array with action name as key at "actions.0"'
            ],
            'action name should start from @'                                => [
                '$data'      => [
                    'actions' => [
                        ['add' => null]
                    ]
                ],
                '$exception' => 'Syntax error: action name should start with "@" symbol,'
                    . ' current name "add" at "actions.0"'
            ],
            'known action proceed'                                           => [
                '$data'      => [
                    'actions' => [
                        ['@add' => null]
                    ]
                ],
                '$exception' => '"add" method requires at least 3 argument(s) to be passed, 1 given at "actions.0"'
            ],
        ];
    }

    // @codingStandardsIgnoreStart
    public function testGenerate()
    {
        $this->assertSame(
<<<CLASS
<?php

/**
 * Filename: testfilename.yml
 */

class testClassName implements \Labudzinski\TestFrameworkBundle\Component\Layout\LayoutUpdateInterface
{
    public function updateLayout(\Labudzinski\TestFrameworkBundle\Component\Layout\LayoutManipulatorInterface \$layoutManipulator, \Labudzinski\TestFrameworkBundle\Component\Layout\LayoutItemInterface \$item)
    {
        \$layoutManipulator->add( 'root', NULL, 'root' );
        \$layoutManipulator->add( 'header', 'root', 'header' );
        \$layoutManipulator->addAlias( 'header', 'header_alias' );
    }
}
CLASS
            ,
            $this->generator->generate(
                'testClassName',
                new GeneratorData(
                    [
                        'actions' => [
                            [
                                '@add' => [
                                    'id'        => 'root',
                                    'parentId'  => null,
                                    'blockType' => 'root'
                                ]
                            ],
                            [
                                '@add' => [
                                    'id'        => 'header',
                                    'parentId'  => 'root',
                                    'blockType' => 'header'
                                ]
                            ],
                            [
                                '@addAlias' => [
                                    'alias' => 'header',
                                    'id'    => 'header_alias',
                                ]
                            ]
                        ]
                    ],
                    'testfilename.yml'
                )
            )
        );
    }
    // @codingStandardsIgnoreEnd
}
