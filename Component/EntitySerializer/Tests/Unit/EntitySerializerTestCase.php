<?php

namespace Labudzinski\TestFrameworkBundle\Component\EntitySerializer\Tests\Unit;

use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use Labudzinski\TestFrameworkBundle\Component\DoctrineUtils\ORM\QueryHintResolverInterface;
use Labudzinski\TestFrameworkBundle\Component\EntitySerializer\ConfigConverter;
use Labudzinski\TestFrameworkBundle\Component\EntitySerializer\ConfigNormalizer;
use Labudzinski\TestFrameworkBundle\Component\EntitySerializer\DataNormalizer;
use Labudzinski\TestFrameworkBundle\Component\EntitySerializer\DoctrineHelper;
use Labudzinski\TestFrameworkBundle\Component\EntitySerializer\EntityDataAccessor;
use Labudzinski\TestFrameworkBundle\Component\EntitySerializer\EntityDataTransformer;
use Labudzinski\TestFrameworkBundle\Component\EntitySerializer\EntityFieldFilterInterface;
use Labudzinski\TestFrameworkBundle\Component\EntitySerializer\EntitySerializer;
use Labudzinski\TestFrameworkBundle\Component\EntitySerializer\FieldAccessor;
use Labudzinski\TestFrameworkBundle\Component\EntitySerializer\QueryFactory;
use Labudzinski\TestFrameworkBundle\Component\EntitySerializer\SerializationHelper;
use Labudzinski\TestFrameworkBundle\Component\EntitySerializer\ValueTransformer;
use Labudzinski\TestFrameworkBundle\Component\TestUtils\ORM\Mocks\EntityManagerMock;
use Labudzinski\TestFrameworkBundle\Component\TestUtils\ORM\OrmTestCase;
use Symfony\Component\DependencyInjection\ContainerInterface;

abstract class EntitySerializerTestCase extends OrmTestCase
{
    /** @var EntityManagerMock */
    protected $em;

    /** @var \PHPUnit_Framework_MockObject_MockObject */
    protected $entityFieldFilter;

    /** @var \PHPUnit_Framework_MockObject_MockObject|ContainerInterface */
    protected $container;

    /** @var EntitySerializer */
    protected $serializer;

    protected function setUp()
    {
        $reader         = new AnnotationReader();
        $metadataDriver = new AnnotationDriver(
            $reader,
            'Labudzinski\TestFrameworkBundle\Component\EntitySerializer\Tests\Unit\Fixtures\Entity'
        );

        $this->em = $this->getTestEntityManager();
        $this->em->getConfiguration()->setMetadataDriverImpl($metadataDriver);
        $this->em->getConfiguration()->setEntityNamespaces(
            [
                'Test' => 'Labudzinski\TestFrameworkBundle\Component\EntitySerializer\Tests\Unit\Fixtures\Entity'
            ]
        );

        $doctrine = $this->createMock(ManagerRegistry::class);
        $doctrine->expects($this->any())
            ->method('getManagerForClass')
            ->will($this->returnValue($this->em));
        $doctrine->expects($this->any())
            ->method('getAliasNamespace')
            ->will(
                $this->returnValueMap(
                    [
                        ['Test', 'Labudzinski\TestFrameworkBundle\Component\EntitySerializer\Tests\Unit\Fixtures\Entity']
                    ]
                )
            );

        $this->entityFieldFilter = $this->createMock(EntityFieldFilterInterface::class);
        $this->entityFieldFilter->expects($this->any())
            ->method('isApplicableField')
            ->willReturn(true);

        $this->container = $this->createMock(ContainerInterface::class);

        $queryHintResolver = $this->createMock(QueryHintResolverInterface::class);

        $doctrineHelper   = new DoctrineHelper($doctrine);
        $dataAccessor     = new EntityDataAccessor();
        $fieldAccessor    = new FieldAccessor($doctrineHelper, $dataAccessor, $this->entityFieldFilter);
        $this->serializer = new EntitySerializer(
            $doctrineHelper,
            new SerializationHelper(
                new EntityDataTransformer($this->container, new ValueTransformer())
            ),
            $dataAccessor,
            new QueryFactory($doctrineHelper, $queryHintResolver),
            $fieldAccessor,
            new ConfigNormalizer(),
            new ConfigConverter(),
            new DataNormalizer()
        );
    }

    /**
     * @param array  $expected
     * @param array  $actual
     * @param string $message
     */
    protected function assertArrayEquals(array $expected, array $actual, $message = '')
    {
        $this->sortByKeyRecursive($expected);
        $this->sortByKeyRecursive($actual);
        $this->assertSame($expected, $actual, $message);
    }

    /**
     * @param string $expected
     * @param string $actual
     * @param string $message
     */
    protected function assertDqlEquals($expected, $actual, $message = '')
    {
        $expected = str_replace('Test:', 'Labudzinski\TestFrameworkBundle\Component\EntitySerializer\Tests\Unit\Fixtures\Entity\\', $expected);
        $this->assertEquals($expected, $actual, $message);
    }

    /**
     * @param array $array
     */
    protected function sortByKeyRecursive(array &$array)
    {
        ksort($array);
        foreach ($array as &$val) {
            if ($val && is_array($val)) {
                $this->sortByKeyRecursive($val);
            }
        }
    }
}
