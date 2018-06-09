<?php

namespace Labudzinski\TestFrameworkBundle\Component\Layout\Tests\Unit;

use Labudzinski\TestFrameworkBundle\Component\Layout\Block\OptionsResolver\OptionsResolver;
use Labudzinski\TestFrameworkBundle\Component\Layout\Block\Type\BaseType;
use Labudzinski\TestFrameworkBundle\Component\Layout\Block\Type\ContainerType;
use Labudzinski\TestFrameworkBundle\Component\Layout\Block\Type\Options;
use Labudzinski\TestFrameworkBundle\Component\Layout\BlockBuilderInterface;
use Labudzinski\TestFrameworkBundle\Component\Layout\BlockFactory;
use Labudzinski\TestFrameworkBundle\Component\Layout\BlockInterface;
use Labudzinski\TestFrameworkBundle\Component\Layout\BlockView;
use Labudzinski\TestFrameworkBundle\Component\Layout\DeferredLayoutManipulator;
use Labudzinski\TestFrameworkBundle\Component\Layout\ExpressionLanguage\Encoder\ExpressionEncoderRegistry;
use Labudzinski\TestFrameworkBundle\Component\Layout\ExpressionLanguage\ExpressionProcessor;
use Labudzinski\TestFrameworkBundle\Component\Layout\Extension\Core\CoreExtension;
use Labudzinski\TestFrameworkBundle\Component\Layout\Extension\PreloadedExtension;
use Labudzinski\TestFrameworkBundle\Component\Layout\LayoutContext;
use Labudzinski\TestFrameworkBundle\Component\Layout\LayoutItemInterface;
use Labudzinski\TestFrameworkBundle\Component\Layout\LayoutManipulatorInterface;
use Labudzinski\TestFrameworkBundle\Component\Layout\LayoutRegistry;
use Labudzinski\TestFrameworkBundle\Component\Layout\OptionValueBag;
use Labudzinski\TestFrameworkBundle\Component\Layout\RawLayoutBuilder;
use Labudzinski\TestFrameworkBundle\Component\Layout\Tests\Unit\Fixtures\AbstractExtensionStub;
use Labudzinski\TestFrameworkBundle\Component\Layout\Tests\Unit\Fixtures\Layout\Block\Type;
use Symfony\Component\ExpressionLanguage\ExpressionLanguage;

class BlockFactoryTest extends LayoutTestCase
{
    /** @var LayoutContext */
    protected $context;

    /** @var RawLayoutBuilder */
    protected $rawLayoutBuilder;

    /** @var DeferredLayoutManipulator */
    protected $layoutManipulator;

    /** @var LayoutRegistry */
    protected $registry;

    /** @var ExpressionLanguage */
    protected $expressionLanguage;

    /** @var BlockFactory */
    protected $blockFactory;

    protected function setUp()
    {
        $this->registry = new LayoutRegistry();
        $this->registry->addExtension(new CoreExtension());
        $this->registry->addExtension(
            new PreloadedExtension(
                [
                    'root'                         => new Type\RootType(),
                    'header'                       => new Type\HeaderType(),
                    'logo'                         => new Type\LogoType(),
                    'test_self_building_container' => new Type\TestSelfBuildingContainerType()
                ]
            )
        );

        $this->context            = new LayoutContext();
        $this->rawLayoutBuilder   = new RawLayoutBuilder();
        $this->layoutManipulator  = new DeferredLayoutManipulator($this->registry, $this->rawLayoutBuilder);
        $this->expressionLanguage = new ExpressionLanguage();
        $expressionProcessor      = new ExpressionProcessor(
            $this->expressionLanguage,
            new ExpressionEncoderRegistry([])
        );
        $this->blockFactory       = new BlockFactory(
            $this->registry,
            $this->layoutManipulator,
            $expressionProcessor
        );
    }

    /**
     * @param string|null $rootId
     *
     * @return BlockView
     */
    protected function getLayoutView($rootId = null)
    {
        $this->layoutManipulator->applyChanges($this->context, true);
        $rawLayout = $this->rawLayoutBuilder->getRawLayout();

        return $this->blockFactory->createBlockView($rawLayout, $this->context, $rootId);
    }

    public function testSimpleLayout()
    {
        $this->layoutManipulator
            ->add('root', null, 'root')
            ->add('header', 'root', 'header')
            ->add('logo', 'header', 'logo', ['title' => 'test']);

        $view = $this->getLayoutView();

        $this->assertBlockView(
            [ // root
                'vars'     => ['id' => 'root'],
                'children' => [
                    [ // header
                        'vars'     => ['id' => 'header'],
                        'children' => [
                            [ // logo
                                'vars' => ['id' => 'logo', 'title' => 'test']
                            ]
                        ]
                    ]
                ]
            ],
            $view
        );
    }

    public function testCoreVariablesForRootItemOnly()
    {
        $this->layoutManipulator
            ->add('rootId', null, 'root');

        $view = $this->getLayoutView();

        $this->assertBlockView(
            [ // root
                'vars'     => [
                    'id'                   => 'rootId',
                    'block_type'           => 'root',
                    'block_type_widget_id' => 'root_widget',
                    'translation_domain'   => 'messages',
                    'unique_block_prefix'  => '_rootId',
                    'block_prefixes'       => [
                        BaseType::NAME,
                        ContainerType::NAME,
                        'root',
                        '_rootId'
                    ],
                    'cache_key'            => '_rootId_root'
                ],
                'children' => []
            ],
            $view,
            false
        );
    }

    public function testCoreVariables()
    {
        $this->layoutManipulator
            ->add('rootId', null, 'root')
            ->add('headerId', 'rootId', 'header')
            ->add('logoId', 'headerId', 'logo', ['title' => 'test']);

        $view = $this->getLayoutView();

        $this->assertBlockView(
            [ // root
                'vars'     => [
                    'id'                   => 'rootId',
                    'block_type'           => 'root',
                    'block_type_widget_id' => 'root_widget',
                    'translation_domain'   => 'messages',
                    'unique_block_prefix'  => '_rootId',
                    'block_prefixes'       => [
                        BaseType::NAME,
                        ContainerType::NAME,
                        'root',
                        '_rootId'
                    ],
                    'cache_key'            => '_rootId_root'
                ],
                'children' => [
                    [ // header
                        'vars'     => [
                            'id'                   => 'headerId',
                            'block_type'           => 'header',
                            'block_type_widget_id' => 'header_widget',
                            'translation_domain'   => 'messages',
                            'unique_block_prefix'  => '_headerId',
                            'block_prefixes'       => [
                                BaseType::NAME,
                                ContainerType::NAME,
                                'header',
                                '_headerId'
                            ],
                            'cache_key'            => '_headerId_header'
                        ],
                        'children' => [
                            [ // logo
                                'vars' => [
                                    'id'                   => 'logoId',
                                    'block_type'           => 'logo',
                                    'block_type_widget_id' => 'logo_widget',
                                    'translation_domain'   => 'messages',
                                    'unique_block_prefix'  => '_logoId',
                                    'block_prefixes'       => [
                                        BaseType::NAME,
                                        'logo',
                                        '_logoId'
                                    ],
                                    'cache_key'            => '_logoId_logo',
                                    'title'                => 'test'
                                ]
                            ]
                        ]
                    ]
                ]
            ],
            $view,
            false
        );
    }

    // @codingStandardsIgnoreStart
    /**
     * @expectedException \Labudzinski\TestFrameworkBundle\Component\Layout\Exception\LogicException
     * @expectedExceptionMessage The "header" item cannot be added as a child to "logo" item (block type: logo) because only container blocks can have children.
     */
    // @codingStandardsIgnoreEnd
    public function testAddChildToNotContainer()
    {
        $this->layoutManipulator
            ->add('root', null, 'root')
            ->add('logo', 'root', 'logo')
            ->add('header', 'logo', 'header');

        $this->getLayoutView();
    }

    /**
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    public function testExtensions()
    {
        $testBlockType = $this->createMock('Labudzinski\TestFrameworkBundle\Component\Layout\Block\Type\AbstractType');
        $testBlockType->expects($this->any())
            ->method('getName')
            ->will($this->returnValue('test'));
        $testBlockType->expects($this->any())
            ->method('getParent')
            ->will($this->returnValue(BaseType::NAME));

        $headerLayoutUpdate = $this->createMock('Labudzinski\TestFrameworkBundle\Component\Layout\LayoutUpdateInterface');
        $headerLayoutUpdate->expects($this->once())
            ->method('updateLayout')
            ->will(
                $this->returnCallback(
                    function (LayoutManipulatorInterface $layoutManipulator, LayoutItemInterface $item) {
                        $layoutManipulator->add('test', 'header', 'test');
                    }
                )
            );

        $headerBlockTypeExtension = $this->createMock('Labudzinski\TestFrameworkBundle\Component\Layout\BlockTypeExtensionInterface');
        $headerBlockTypeExtension->expects($this->any())
            ->method('getExtendedType')
            ->will($this->returnValue('header'));
        $headerBlockTypeExtension->expects($this->once())
            ->method('configureOptions')
            ->will(
                $this->returnCallback(
                    function (OptionsResolver $resolver) {
                        $resolver->setDefaults(
                            [
                                'test_option_1' => '',
                                'test_option_2' => ['background'=> 'red']
                            ]
                        );
                    }
                )
            );
        $headerBlockTypeExtension->expects($this->once())
            ->method('buildBlock')
            ->will(
                $this->returnCallback(
                    function (BlockBuilderInterface $builder, Options $options) {
                        if ($options['test_option_1'] === 'move_logo_to_root') {
                            $builder->getLayoutManipulator()->move('logo', 'root');
                        }
                    }
                )
            );
        $headerBlockTypeExtension->expects($this->once())
            ->method('buildView')
            ->will(
                $this->returnCallback(
                    function (BlockView $view, BlockInterface $block, Options $options) {
                        $view->vars['attr']['block_id'] = $block->getId();
                        if ($options['test_option_1'] === 'move_logo_to_root') {
                            $view->vars['attr']['logo_moved'] = true;
                        }
                        $view->vars['attr']['background'] = $options['test_option_2']['background'];
                    }
                )
            );
        $headerBlockTypeExtension->expects($this->once())
            ->method('finishView')
            ->will(
                $this->returnCallback(
                    function (BlockView $view, BlockInterface $block) {
                        if (isset($view['test'])) {
                            $view['test']->vars['processed_by_header_extension'] = true;
                        }
                    }
                )
            );

        $this->registry->addExtension(
            new AbstractExtensionStub(
                [$testBlockType],
                [$headerBlockTypeExtension],
                [
                    'header' => [$headerLayoutUpdate]
                ],
                [],
                []
            )
        );

        $this->layoutManipulator
            ->add('root', null, 'root')
            ->add('header', 'root', 'header', ['test_option_1' => 'move_logo_to_root'])
            ->add('logo', 'header', 'logo', ['title' => 'test']);

        $view = $this->getLayoutView();

        $this->assertBlockView(
            [ // root
                'vars'     => ['id' => 'root'],
                'children' => [
                    [ // header
                        'vars'     => [
                            'id'   => 'header',
                            'attr' => [
                                'block_id'   => 'header',
                                'logo_moved' => true,
                                'background' => 'red'
                            ]
                        ],
                        'children' => [
                            [ // test
                                'vars' => [
                                    'id'                            => 'test',
                                    'processed_by_header_extension' => true
                                ]
                            ]
                        ]
                    ],
                    [ // logo
                        'vars' => ['id' => 'logo', 'title' => 'test']
                    ]
                ]
            ],
            $view
        );
    }

    /**
     * @dataProvider expressionsProvider
     *
     * @param bool $deferred
     */
    public function testProcessingExpressionsInBuildView($deferred)
    {
        $this->context->set('expressions_evaluate', true);
        $this->context->set('expressions_evaluate_deferred', $deferred);
        $this->context->set('title', 'test title');

        $this->layoutManipulator
            ->add('root', null, 'root')
            ->add('header', 'root', 'header')
            ->add('logo', 'header', 'logo', [
                'title' => $this->expressionLanguage->parse('context["title"]', ['context'])
            ]);

        $view = $this->getLayoutView();

        $this->assertBlockView(
            [ // root
                'vars'     => ['id' => 'root'],
                'children' => [
                    [ // header
                        'vars'     => ['id' => 'header'],
                        'children' => [
                            [ // logo
                                'vars' => ['id' => 'logo', 'title' => 'test title']
                            ]
                        ]
                    ]
                ]
            ],
            $view
        );
    }

    /**
     * @return array
     */
    public function expressionsProvider()
    {
        return [
            ['deferred' => false],
            ['deferred' => true],
        ];
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testBuildViewShouldFailWhenUsingNonProcessedExpressions()
    {
        $this->context->set('expressions_evaluate', false);
        $this->context->set('title', 'test title');

        $this->layoutManipulator
            ->add('root', null, 'root')
            ->add('header', 'root', 'header')
            ->add('logo', 'header', 'logo', [
                'title' => $this->expressionLanguage->parse('context["title"]', ['context'])
            ]);

        $this->getLayoutView();
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testBuildViewShouldFailWhenUsingDataInExpressionsInDeferredMode()
    {
        $this->context->set('expressions_evaluate', true);
        $this->context->set('expressions_evaluate_deferred', true);
        $this->context->data()->set('title', 'test title');

        $this->layoutManipulator
            ->add('root', null, 'root')
            ->add('header', 'root', 'header')
            ->add('logo', 'header', 'logo', [
                'title' => $this->expressionLanguage->parse('data["title"]', ['data'])
            ]);

        $this->getLayoutView();
    }

    public function testResolvingValueBags()
    {
        $valueBag = new OptionValueBag();
        $valueBag->add('one');
        $valueBag->add('two');

        $this->context->set('expressions_evaluate', true);

        $this->layoutManipulator
            ->add('root', null, 'root')
            ->add('header', 'root', 'header')
            ->add('logo', 'header', 'logo', ['title' => $valueBag]);

        $view = $this->getLayoutView();

        $this->assertBlockView(
            [ // root
                'vars'     => ['id' => 'root'],
                'children' => [
                    [ // header
                        'vars'     => ['id' => 'header'],
                        'children' => [
                            [ // logo
                                'vars' => ['id' => 'logo', 'title' => 'one two']
                            ]
                        ]
                    ]
                ]
            ],
            $view
        );
    }
}
